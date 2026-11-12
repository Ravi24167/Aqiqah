@extends('layouts.app')

@section('title', 'Pendaftaran DKM Masjid Baru - AqiqahKita')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-emerald-50 via-white to-amber-50">
    <div class="max-w-xl w-full space-y-6 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-emerald-100">
        
        <div class="text-center space-y-2">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-amber-500 items-center justify-center text-white text-3xl shadow-lg shadow-emerald-500/20">
                <i class="fa-solid fa-mosque"></i>
            </div>
            <h2 class="text-3xl font-black font-heading text-slate-900">Pendaftaran DKM Masjid Baru</h2>
            <p class="text-xs text-slate-500">Daftarkan DKM Masjid Anda untuk mengelola paket hewan kurban & aqiqah.</p>
        </div>

        <!-- Security Warning Banner -->
        <div class="bg-amber-50 border-2 border-amber-300 p-4 rounded-2xl flex items-start gap-3">
            <i class="fa-solid fa-shield-halved text-amber-600 text-2xl mt-0.5"></i>
            <div class="text-xs text-amber-900">
                <strong class="font-extrabold block text-sm mb-0.5">Keamanan Akun (Persetujuan Super Admin):</strong>
                Demi menjaga kepercayaan jamaah, akun DKM yang baru didaftarkan wajib menunggu persetujuan (approval) dari Super Admin sebelum dapat login dan menjual hewan.
            </div>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold p-4 rounded-2xl space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.dkm') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Nama Penanggung Jawab</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Ustadz / Pengurus DKM"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Nama Masjid / DKM</label>
                    <input type="text" name="masjid_name" required value="{{ old('masjid_name') }}" placeholder="Masjid Al-Barkah"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Email Resmi DKM</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="dkm.albarkah@gmail.com"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone_number" required value="{{ old('phone_number') }}" placeholder="08123456789"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Alamat Masjid Lengkap</label>
                <textarea name="address" rows="2" required placeholder="Jl. Raya Masjid No. 12, Kel. Sukamaju, Kec. Cilandak, Jakarta"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-amber-500 hover:from-emerald-700 hover:to-amber-600 text-white font-black text-sm py-3.5 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran & Minta Persetujuan
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah memiliki akun DKM? <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Masuk Ke Panel</a>
        </div>

    </div>
</div>
@endsection
