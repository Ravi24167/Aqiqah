@extends('layouts.app')

@section('title', 'Super Admin Dashboard - Persetujuan DKM Masjid')

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]" x-data="{ rejectionDialogOpen: false, rejectionForm: null, rejectionReason: '', openRejectionDialog(form) { this.rejectionForm = form; this.rejectionReason = ''; this.rejectionDialogOpen = true; }, submitRejectionForm() { if (this.rejectionForm) { this.rejectionForm.querySelector('[name=reason]').value = this.rejectionReason.trim(); this.rejectionForm.requestSubmit(); } } }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 p-8 rounded-3xl text-white shadow-xl">
            <div>
                <div class="inline-flex items-center gap-2 bg-amber-500/20 text-amber-300 border border-amber-400/30 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    <i class="fa-solid fa-crown"></i> Super Admin Control Panel
                </div>
                <h1 class="text-3xl font-black font-heading">Persetujuan & Manajemen DKM Masjid</h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">Verifikasi pendaftaran DKM Masjid baru agar dapat menjual hewan kurban & aqiqah.</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 text-center">
                <span class="text-xs text-amber-300 font-bold block uppercase">Permohonan Pending</span>
                <span class="text-3xl font-black font-heading text-white">{{ $stats['total_pending'] }}</span>
            </div>
        </div>

        <!-- Metrics Overview Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Pending Approval</span>
                    <h3 class="text-2xl font-black font-heading text-slate-900">{{ $stats['total_pending'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="fa-solid fa-square-check"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">DKM Disetujui</span>
                    <h3 class="text-2xl font-black font-heading text-slate-900">{{ $stats['total_approved'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="fa-solid fa-cow"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Hewan</span>
                    <h3 class="text-2xl font-black font-heading text-slate-900">{{ $stats['total_animals'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-black">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Chat Jamaah</span>
                    <h3 class="text-2xl font-black font-heading text-slate-900">{{ $stats['total_chats'] }}</h3>
                </div>
            </div>
        </div>

        <!-- SECTION 1: PENDING DKM APPROVALS TABLE -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
                    <h2 class="text-lg font-black font-heading text-slate-900">
                        Permohonan Pendaftaran DKM Baru (Menunggu Approval)
                    </h2>
                </div>
                <span class="bg-amber-500 text-white font-black text-xs px-3 py-1 rounded-full">
                    {{ $pendingDkms->count() }} Permohonan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-600 font-extrabold uppercase border-b border-slate-200">
                            <th class="p-4">Nama DKM & Masjid</th>
                            <th class="p-4">Pengurus Admin</th>
                            <th class="p-4">Kontak / WA</th>
                            <th class="p-4">Alamat Masjid</th>
                            <th class="p-4 text-center">Tindakan Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($pendingDkms as $dkm)
                            <tr class="hover:bg-amber-50/50 transition-colors">
                                <td class="p-4 font-bold text-slate-900">
                                    <div class="text-sm font-black text-emerald-800">{{ $dkm->masjid_name }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $dkm->email }}</div>
                                </td>
                                <td class="p-4 text-slate-800 font-bold">
                                    {{ $dkm->name }}
                                </td>
                                <td class="p-4 text-slate-700">
                                    <span class="bg-emerald-100 text-emerald-800 font-bold px-2 py-1 rounded-md">
                                        <i class="fa-brands fa-whatsapp text-emerald-600"></i> {{ $dkm->phone_number }}
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600 max-w-xs truncate">
                                    {{ $dkm->address }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('superadmin.approve', $dkm->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs px-4 py-2 rounded-xl shadow-md transition-all flex items-center gap-1.5">
                                                <i class="fa-solid fa-check"></i> SETUJUI AKUN
                                            </button>
                                        </form>

                                        <form action="{{ route('superadmin.reject', $dkm->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="reason" value="">
                                            <button type="button" @click="openRejectionDialog($event.currentTarget.form)" class="bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-xs px-3 py-2 rounded-xl transition-all">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 font-bold">
                                    <i class="fa-solid fa-circle-check text-2xl text-emerald-500 mb-2"></i>
                                    <div>Tidak ada permohonan pendaftaran DKM yang pending saat ini.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECTION 2: APPROVED DKM MOSQUES TABLE -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 bg-slate-100 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-black font-heading text-slate-900">
                    Daftar DKM Masjid Terverifikasi & Aktif
                </h2>
                <span class="bg-emerald-600 text-white font-black text-xs px-3 py-1 rounded-full">
                    {{ $approvedDkms->count() }} Masjid Aktif
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-extrabold uppercase border-b border-slate-200">
                            <th class="p-4">Nama DKM</th>
                            <th class="p-4">Penanggung Jawab</th>
                            <th class="p-4">Alamat</th>
                            <th class="p-4 text-center">Status Akses</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($approvedDkms as $dkm)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $dkm->masjid_name }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $dkm->email }}</div>
                                </td>
                                <td class="p-4 font-bold text-slate-800">{{ $dkm->name }}</td>
                                <td class="p-4 text-slate-600 max-w-xs truncate">{{ $dkm->address }}</td>
                                <td class="p-4 text-center">
                                    <span class="bg-emerald-100 text-emerald-800 text-[11px] font-black px-3 py-1 rounded-full">
                                        ✓ AKTIF & DISETUJUI
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('superadmin.toggle', $dkm->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs px-3 py-1.5 rounded-xl transition-all">
                                            Nonaktifkan Akses
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div x-show="rejectionDialogOpen" x-transition.opacity style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4" @click.self="rejectionDialogOpen = false" @keydown.escape.window="rejectionDialogOpen = false">
        <section role="dialog" aria-modal="true" aria-labelledby="rejection-dialog-title" class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl sm:p-8">
            <div class="mb-5 flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div>
                    <h2 id="rejection-dialog-title" class="text-xl font-black text-slate-900">Tolak pendaftaran DKM?</h2>
                    <p class="mt-1 text-sm text-slate-600">Status pendaftaran akan ditolak. Alasan bersifat opsional.</p>
                </div>
            </div>

            <label for="rejection-reason" class="mb-2 block text-sm font-bold text-slate-700">Alasan penolakan</label>
            <textarea id="rejection-reason" x-model="rejectionReason" maxlength="1000" rows="4" class="w-full resize-y rounded-2xl border border-slate-300 p-3 text-sm text-slate-900 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20" placeholder="Contoh: Data masjid belum lengkap"></textarea>
            <p class="mt-1 text-xs text-slate-500">Maksimal 1000 karakter. Kosongkan jika tidak ingin mencantumkan alasan.</p>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="rejectionDialogOpen = false" class="rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-200">
                    Batal
                </button>
                <button type="button" @click="submitRejectionForm()" class="flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-rose-700">
                    <i class="fa-solid fa-xmark"></i> Ya, Tolak Pendaftaran
                </button>
            </div>
        </section>
    </div>
</div>
@endsection
