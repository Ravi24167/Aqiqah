<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\UniqueConstraintViolationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if DKM Admin is approved
            if ($user->isDkmAdmin() && !$user->is_approved) {
                Auth::logout();
                if ($user->isRejected()) {
                    return back()->withErrors([
                        'email' => 'Pendaftaran akun DKM Anda telah ditolak. Silakan cek email Anda atau hubungi Super Admin untuk penjelasan.',
                    ]);
                }
                return back()->withErrors([
                    'email' => 'Akun DKM Anda masih MENUNGGU PERSETUJUAN dari Super Admin. Silakan hubungi Super Admin untuk proses aktivasi akun.',
                ]);
            }

            if ($user->isSuperAdmin()) {
                return redirect()->route('superadmin.dashboard');
            }

            return redirect()->route('dkm.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    public function showRegisterDkm()
    {
        return view('auth.register-dkm');
    }

    public function registerDkm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->input('email'), 'email')],
            'password' => 'required|string|min:6|confirmed',
            'masjid_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // After validation: a previously rejected DKM may re-register with the same email.
        // NOTE: unique rule still excludes the rejected account's own row so the
        // update path below is not blocked; active/approved accounts still collide.
        $rejected = User::where('role', 'dkm_admin')
            ->where('email', $validated['email'])
            ->whereNotNull('rejected_at')
            ->first();

        if (!$rejected) {
            // Re-validate uniqueness without any ignore() so an existing active
            // account with this email is firmly rejected.
            $request->validate([
                'email' => Rule::unique('users', 'email'),
            ]);
        }

        $attributes = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'dkm_admin',
            'masjid_name' => $validated['masjid_name'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'is_approved' => false, // MUST BE APPROVED BY SUPER ADMIN
        ];

        try {
            DB::transaction(function () use ($rejected, $attributes) {
                if ($rejected) {
                    $rejected->forceFill($attributes + ['rejected_at' => null, 'rejection_reason' => null])->save();
                } else {
                    User::create($attributes);
                }
            });
        } catch (UniqueConstraintViolationException $e) {
            // Race: another request created/claimed this email between validate and save.
            return back()->withErrors(['email' => 'Email ini sudah terdaftar.'])->withInput();
        }

        return redirect()->route('login')->with('status', 'Pendaftaran DKM Masjid berhasil! Akun Anda telah dibuat dan MENUNGGU PERSETUJUAN Super Admin sebelum dapat masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
