@extends('layouts.app')

@section('title', 'Masuk Admin DKM / Super Admin - AqiqahKita')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-emerald-50 via-white to-amber-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-emerald-100">
        
        <div class="text-center space-y-2">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-amber-500 items-center justify-center text-white text-3xl shadow-lg shadow-emerald-500/20">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-3xl font-black font-heading text-slate-900">Masuk Akun Admin</h2>
            <p class="text-xs text-slate-500">Silakan login untuk mengelola katalog hewan & menjawab chat jamaah.</p>
        </div>

        @if(session('status'))
            <div class="bg-amber-50 border border-amber-300 text-amber-900 text-xs font-bold p-4 rounded-2xl flex items-start gap-2">
                <i class="fa-solid fa-circle-info text-amber-600 text-base"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

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

        <form action="{{ route('login') }}" method="POST" class="mt-8 space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-2">Email Masjid / Admin</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="contoh: dkm.alfalah@aqiqah.com"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm py-3.5 rounded-2xl shadow-lg shadow-emerald-500/25 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500 space-y-2">
            <div>Belum mendaftarkan DKM Masjid Anda?</div>
            <a href="{{ route('register.dkm') }}" class="inline-block text-emerald-600 font-black hover:underline">
                Daftar Akun DKM Masjid Baru &rarr;
            </a>
            <div class="text-[10px] text-slate-400 pt-2">
                *Akun Super Admin bawaan: <code>superadmin@aqiqah.com</code> / Pass: <code>password</code>
            </div>
        </div>

    </div>
</div>
@endsection
