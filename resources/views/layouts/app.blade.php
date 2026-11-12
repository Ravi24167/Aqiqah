<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aqiqah & Ternak Qurban - Layanan Hewan Kurban & Aqiqah Harian')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        vibrantGreen: {
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FFFFFF;
            color: #1E293B;
            touch-action: manipulation;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        .pulse-hotspot {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            animation: pulse-ring 1.8s infinite;
        }
        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            }
            70% {
                transform: scale(1.15);
                box-shadow: 0 0 0 12px rgba(245, 158, 11, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }
        .chat-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04), 0 0 20px rgba(16, 185, 129, 0.15);
        }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen bg-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Bar (Vibrant Rich Emerald Green) -->
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 text-white text-[11px] md:text-xs lg:text-sm font-extrabold py-2 px-3 sm:px-4 text-center tracking-wide flex items-center justify-center gap-2 shadow-md">
        <span class="bg-amber-400 text-slate-950 px-2 py-0.5 rounded-full text-[10px] md:text-xs uppercase font-black shrink-0">24/7</span>
        <span class="truncate sm:whitespace-normal">✨ Pemesanan Hewan Aqiqah & Qurban Fleksibel Kapan Saja!</span>
    </div>

    <!-- Header Navigation (Clean White with Mobile Drawer support) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b-2 border-emerald-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-500 flex items-center justify-center text-white text-xl sm:text-2xl shadow-md shadow-emerald-600/30 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-cloud-meatball"></i>
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-black font-heading tracking-tight bg-gradient-to-r from-emerald-700 via-emerald-600 to-amber-600 bg-clip-text text-transparent">AqiqahKita</span>
                        <span class="block text-[9px] sm:text-xs font-black text-amber-600 tracking-wider">BERKAH & TERPECAYA</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-extrabold text-slate-800">
                    <a href="{{ route('home') }}#catalog" class="hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-emerald-600"></i> Katalog Hewan
                    </a>
                    <a href="{{ route('anatomy.hub') }}" class="hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-bullseye text-amber-500"></i> Anatomi & Manfaat
                    </a>
                    <a href="{{ route('home') }}#dkm-section" class="hover:text-emerald-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-mosque text-emerald-600"></i> Mitra DKM Masjid
                    </a>
                </nav>

                <!-- Auth / Admin Actions -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(Auth::user()->isSuperAdmin())
                            <a href="{{ route('superadmin.dashboard') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-black text-xs md:text-sm px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-2">
                                <i class="fa-solid fa-user-shield"></i> Panel Super Admin
                            </a>
                        @else
                            <a href="{{ route('dkm.dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs md:text-sm px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-2">
                                <i class="fa-solid fa-mosque"></i> Panel DKM Admin
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs md:text-sm px-3 py-2.5 rounded-xl transition-all">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-emerald-700 hover:text-emerald-900 font-black text-xs md:text-sm px-3 py-2">
                            Masuk Admin DKM
                        </a>
                        <a href="{{ route('register.dkm') }}" class="bg-gradient-to-r from-emerald-600 to-amber-500 hover:from-emerald-700 hover:to-amber-600 text-white font-black text-xs md:text-sm px-4 py-2.5 rounded-xl shadow-md shadow-emerald-600/30 hover:scale-[1.02] transition-all flex items-center gap-2">
                            <i class="fa-solid fa-id-card"></i> Daftar DKM Masjid
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl bg-emerald-50 text-emerald-800 font-black text-lg focus:outline-none">
                    <i :class="mobileMenuOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-b border-emerald-100 px-4 pt-3 pb-6 space-y-4 shadow-xl">
            <nav class="flex flex-col space-y-3 font-extrabold text-sm text-slate-800">
                <a href="{{ route('home') }}#catalog" @click="mobileMenuOpen = false" class="p-2 hover:bg-emerald-50 rounded-xl flex items-center gap-2 text-emerald-800">
                    <i class="fa-solid fa-layer-group"></i> Katalog Hewan
                </a>
                <a href="{{ route('anatomy.hub') }}" @click="mobileMenuOpen = false" class="p-2 hover:bg-emerald-50 rounded-xl flex items-center gap-2 text-amber-600">
                    <i class="fa-solid fa-bullseye"></i> Anatomi & Manfaat
                </a>
                <a href="{{ route('home') }}#dkm-section" @click="mobileMenuOpen = false" class="p-2 hover:bg-emerald-50 rounded-xl flex items-center gap-2 text-emerald-800">
                    <i class="fa-solid fa-mosque"></i> Mitra DKM Masjid
                </a>
            </nav>

            <div class="pt-3 border-t border-slate-100 flex flex-col space-y-2">
                @auth
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('superadmin.dashboard') }}" class="w-full bg-amber-500 text-white font-black text-xs py-3 rounded-xl text-center shadow-md">
                            Panel Super Admin
                        </a>
                    @else
                        <a href="{{ route('dkm.dashboard') }}" class="w-full bg-emerald-600 text-white font-black text-xs py-3 rounded-xl text-center shadow-md">
                            Panel DKM Admin
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-slate-100 text-slate-700 font-bold text-xs py-2.5 rounded-xl text-center">
                            Keluar / Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full bg-slate-100 text-slate-800 font-black text-xs py-3 rounded-xl text-center border border-slate-200">
                        Masuk Admin DKM
                    </a>
                    <a href="{{ route('register.dkm') }}" class="w-full bg-emerald-600 text-white font-black text-xs py-3 rounded-xl text-center shadow-md">
                        Daftar DKM Masjid Baru
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow bg-white">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-900 font-extrabold px-4 py-3 rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-rose-100 border border-rose-300 text-rose-800 font-bold px-4 py-3 rounded-2xl flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- VERY BOTTOM FOOTER -->
    <footer class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 text-white pt-12 pb-10 sm:pt-16 sm:pb-12 border-t-4 border-amber-400 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10">
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-white text-emerald-700 flex items-center justify-center text-xl shadow-lg font-black">
                            <i class="fa-solid fa-cloud-meatball"></i>
                        </div>
                        <span class="text-2xl font-black font-heading text-white">AqiqahKita</span>
                    </div>
                    <p class="text-xs sm:text-sm text-white font-medium leading-relaxed">
                        Platform penyedia hewan Aqiqah, Qurban, dan Kebutuhan Daging Harian terpercaya terhubung langsung dengan DKM Masjid lokal seluruh Indonesia.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-black font-heading mb-3 text-base sm:text-lg border-b-2 border-amber-400 inline-block pb-1">Layanan Kami</h4>
                    <ul class="space-y-2 text-xs sm:text-sm font-bold text-white">
                        <li><a href="#" class="hover:text-amber-300">Kambing & Domba Aqiqah</a></li>
                        <li><a href="#" class="hover:text-amber-300">Sapi Kurban Idul Adha</a></li>
                        <li><a href="#" class="hover:text-amber-300">Ternak Harian & Syukuran</a></li>
                        <li><a href="#" class="hover:text-amber-300">Tabungan Kurban Bersama DKM</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-black font-heading mb-3 text-base sm:text-lg border-b-2 border-amber-400 inline-block pb-1">Panduan & Edukasi</h4>
                    <ul class="space-y-2 text-xs sm:text-sm font-bold text-white">
                        <li><a href="{{ route('anatomy.hub') }}" class="hover:text-amber-300">Anatomi & Manfaat Daging</a></li>
                        <li><a href="{{ route('anatomy.hub') }}" class="hover:text-amber-300">Rekomendasi Masakan Khas</a></li>
                        <li><a href="#" class="hover:text-amber-300">Syarat Syar'i Hewan Aqiqah</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-black font-heading mb-3 text-base sm:text-lg border-b-2 border-amber-400 inline-block pb-1">Kemitraan DKM</h4>
                    <p class="text-xs sm:text-sm font-medium text-white mb-3">Ingin mendaftarkan DKM Masjid Anda menjadi penyedia hewan terverifikasi?</p>
                    <a href="{{ route('register.dkm') }}" class="inline-block bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs px-5 py-3 rounded-xl transition-all shadow-xl">
                        Daftar DKM Admin Baru
                    </a>
                </div>
            </div>

            <div class="mt-10 sm:mt-12 pt-6 border-t border-white/30 text-center text-xs font-bold text-white">
                &copy; {{ date('Y') }} AqiqahKita. All rights reserved. Platform Aqiqah & Qurban Fleksibel Indonesia.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
