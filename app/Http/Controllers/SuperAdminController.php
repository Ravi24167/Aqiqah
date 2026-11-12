<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Animal;
use App\Models\ChatMessage;
use App\Notifications\DkmRegistrationRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class SuperAdminController extends Controller
{
    public function index()
    {
        $pendingDkms = User::where('role', 'dkm_admin')->where('is_approved', false)->whereNull('rejected_at')->latest()->get();
        $approvedDkms = User::where('role', 'dkm_admin')->where('is_approved', true)->latest()->get();

        $stats = [
            'total_pending' => $pendingDkms->count(),
            'total_approved' => $approvedDkms->count(),
            'total_animals' => Animal::count(),
            'total_chats' => ChatMessage::count(),
        ];

        return view('superadmin.dashboard', compact('pendingDkms', 'approvedDkms', 'stats'));
    }

    public function approveDkm($id)
    {
        $user = User::where('role', 'dkm_admin')->findOrFail($id);
        $user->is_approved = true;
        $user->rejected_at = null;
        $user->rejection_reason = null;
        $user->save();

        return redirect()->back()->with('success', 'Akun DKM (' . $user->masjid_name . ') telah berhasil DISETUJUI! Admin DKM sekarang dapat login.');
    }

    public function rejectDkm(Request $request, $id)
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:1000']]);

        $user = User::where('role', 'dkm_admin')->findOrFail($id);

        // Sudah ditolak sebelumnya: tidak ada perubahan status, tidak ada email duplikat.
        if ($user->isRejected()) {
            return redirect()->back()->with('success', 'Pendaftaran DKM ini sudah ditolak sebelumnya.');
        }

        $reason = trim((string) $request->input('reason'));

        $user->is_approved = false;
        $user->rejected_at = now();
        $user->rejection_reason = $reason !== '' ? $reason : null;
        $user->save();

        $mailer = config('mail.default');
        $transport = config('mail.mailers.' . $mailer . '.transport');

        if (in_array($transport, ['log', 'array'], true)) {
            Log::warning('Email penolakan pendaftaran DKM tidak dikirim karena mailer hanya menyimpan email secara lokal.', [
                'user_id' => $user->id,
                'mailer' => $mailer,
            ]);

            return redirect()->back()->with('error', 'Pendaftaran DKM telah ditolak, tetapi email belum dikirim. Konfigurasikan SMTP agar pemohon menerima pemberitahuan.');
        }

        // Email dikirim ke email akun (bukan input bebas) hanya setelah status tersimpan.
        try {
            $user->notify(new DkmRegistrationRejected($user->name, $user->masjid_name, $user->rejection_reason));
        } catch (TransportExceptionInterface $e) {
            Log::warning('Gagal mengirim email penolakan pendaftaran DKM.', [
                'user_id' => $user->id,
                'error' => get_class($e) . ': ' . $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Pendaftaran DKM telah ditolak, tetapi email gagal dikirim. Periksa konfigurasi SMTP.');
        }

        return redirect()->back()->with('success', 'Pendaftaran DKM telah ditolak dan pemohon diberi tahu melalui email.');
    }

    public function toggleStatus($id)
    {
        $user = User::where('role', 'dkm_admin')->findOrFail($id);
        $user->is_approved = !$user->is_approved;

        // Approving a previously rejected account must also clear the rejection state,
        // otherwise isRejected() stays true and login behavior becomes inconsistent.
        if ($user->is_approved) {
            $user->rejected_at = null;
            $user->rejection_reason = null;
        }

        $user->save();

        $statusText = $user->is_approved ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'Status akun DKM (' . $user->masjid_name . ') berhasil ' . $statusText . '.');
    }
}
