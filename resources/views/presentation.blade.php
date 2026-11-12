@extends('layouts.app')

@section('title', 'Figma Design Showcase & Presentation Deck - AqiqahKita')

@section('content')
<div class="bg-slate-950 text-white min-h-screen flex flex-col font-sans" x-data="figmaApp()">
    
    <!-- FIGMA TOP TOOLBAR -->
    <header class="bg-slate-900 border-b border-slate-800 px-4 py-3 flex items-center justify-between z-30 sticky top-0">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 via-teal-400 to-amber-400 flex items-center justify-center font-black text-slate-950 text-base shadow-md">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <div>
                    <h1 class="text-sm font-black font-heading text-white flex items-center gap-2">
                        AqiqahKita - Presentation Deck.fig <span class="text-[10px] bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded-md font-mono border border-emerald-500/30">v2.4 Final</span>
                    </h1>
                    <span class="text-[10px] text-slate-400">Design System, User Flows & Feature Specifications</span>
                </div>
            </div>
        </div>

        <!-- Slide Navigator Buttons -->
        <div class="flex items-center gap-2 bg-slate-800 p-1 rounded-xl border border-slate-700">
            <button @click="prevSlide()" class="px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-slate-700 transition-all text-slate-300">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <span class="text-xs font-black text-amber-400 px-2" x-text="`Slide ${currentSlide + 1} / ${slides.length}`"></span>
            <button @click="nextSlide()" class="px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-slate-700 transition-all text-slate-300">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Action Controls -->
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-3.5 py-2 rounded-xl border border-slate-700 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-house"></i> Ke Website Utama
            </a>
            <button @click="presentMode = !presentMode" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black px-4 py-2 rounded-xl shadow-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-play"></i> Mode Presentasi
            </button>
        </div>
    </header>

    <div class="flex-grow flex overflow-hidden relative">
        
        <!-- FIGMA LEFT SIDEBAR (LAYERS & FRAMES) -->
        <aside class="w-64 bg-slate-900 border-r border-slate-800 p-4 space-y-6 hidden lg:block shrink-0 overflow-y-auto max-h-[calc(100vh-60px)]">
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-emerald-400"></i> Slide Frames Navigator
                </h4>
                <div class="space-y-1">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="currentSlide = index" 
                                :class="currentSlide === index ? 'bg-emerald-600/20 text-emerald-300 border-emerald-500/50 font-black' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 border-transparent'"
                                class="w-full text-left px-3 py-2 rounded-xl text-xs border transition-all flex items-center justify-between">
                            <span class="truncate" x-text="`${index + 1}. ${slide.shortTitle}`"></span>
                            <i class="fa-solid fa-chevron-right text-[9px] opacity-40"></i>
                        </button>
                    </template>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-3">
                <h4 class="text-[11px] font-black uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i class="fa-solid fa-palette text-amber-400"></i> Color Tokens
                </h4>
                <div class="grid grid-cols-2 gap-2 text-[10px] font-mono font-bold">
                    <div class="p-2 rounded-lg bg-emerald-600 text-white">#059669<span class="block text-[8px] opacity-80">Primary Green</span></div>
                    <div class="p-2 rounded-lg bg-amber-500 text-slate-950">#F59E0B<span class="block text-[8px] opacity-80">Sun Amber</span></div>
                    <div class="p-2 rounded-lg bg-white text-slate-900 border">#FFFFFF<span class="block text-[8px] opacity-60">Clean White</span></div>
                    <div class="p-2 rounded-lg bg-slate-900 text-slate-300 border border-slate-700">#0F172A<span class="block text-[8px] opacity-80">Dark Slate</span></div>
                </div>
            </div>
        </aside>

        <!-- FIGMA CANVAS CONTAINER -->
        <main class="flex-grow bg-[#141414] p-4 sm:p-8 overflow-y-auto flex items-center justify-center min-h-[calc(100vh-60px)] relative"
              :class="presentMode ? 'fixed inset-0 z-50 bg-slate-950 p-0' : ''">
            
            <!-- Canvas Grid Pattern -->
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

            <!-- Slide Artboard Frame -->
            <div class="w-full max-w-5xl bg-white text-slate-900 rounded-3xl shadow-2xl border-4 border-slate-800 overflow-hidden relative transition-all duration-300"
                 :class="presentMode ? 'h-full max-w-none rounded-none border-none' : ''">
                
                <!-- Frame Header Label -->
                <div class="bg-slate-900 text-slate-300 px-6 py-3 border-b border-slate-800 flex items-center justify-between text-xs font-mono">
                    <div class="flex items-center gap-2 font-bold text-emerald-400">
                        <i class="fa-solid fa-artboard"></i>
                        <span x-text="`Frame #${currentSlide + 1} — ${slides[currentSlide].title}`"></span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-400">
                        <span>1920 x 1080 (16:9)</span>
                        <button x-show="presentMode" @click="presentMode = false" class="text-rose-400 font-bold hover:underline">
                            <i class="fa-solid fa-xmark"></i> Keluar Presentasi
                        </button>
                    </div>
                </div>

                <!-- Slide Content Viewport -->
                <div class="p-6 sm:p-10 min-h-[580px] flex flex-col justify-between space-y-8">
                    
                    <!-- SLIDE 1: COVER -->
                    <template x-if="currentSlide === 0">
                        <div class="space-y-8 my-auto">
                            <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-900 text-xs font-black uppercase px-4 py-1.5 rounded-full">
                                🚀 Presentasi Proposal & System Showcase
                            </div>
                            
                            <h1 class="text-4xl sm:text-6xl font-black font-heading leading-tight text-slate-900">
                                <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-amber-500 bg-clip-text text-transparent">AqiqahKita</span>
                                <span class="block text-2xl sm:text-3xl text-slate-700 mt-2 font-extrabold">Platform Layanan Aqiqah, Qurban & Ternak Fleksibel</span>
                            </h1>

                            <p class="text-slate-600 text-base sm:text-lg max-w-2xl leading-relaxed font-medium">
                                Solusi digital terintegrasi yang menghubungkan jamaah langsung dengan DKM Masjid terpercaya. Dilengkapi anatomi interaktif 100% lengkap, pemesanan tanpa login, dan sistem persetujuan keamanan Super Admin.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                                <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200">
                                    <div class="text-2xl font-black text-emerald-700">365 Hari</div>
                                    <div class="text-xs text-slate-600 font-bold">Pemesanan Kapan Saja</div>
                                </div>
                                <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200">
                                    <div class="text-2xl font-black text-amber-700">100% Syar'i</div>
                                    <div class="text-xs text-slate-600 font-bold">Dikelola DKM Masjid</div>
                                </div>
                                <div class="bg-slate-100 p-4 rounded-2xl border border-slate-200">
                                    <div class="text-2xl font-black text-slate-800">13 Bagian</div>
                                    <div class="text-xs text-slate-600 font-bold">Anatomi & Pemanfaatan</div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 2: PROBLEM & SOLUTION -->
                    <template x-if="currentSlide === 1">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4">
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Latar Belakang & Solusi</span>
                                <h2 class="text-3xl font-black font-heading text-slate-900">Mengapa AqiqahKita Hadir?</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-rose-50 p-6 rounded-2xl border-2 border-rose-200 space-y-3">
                                    <div class="flex items-center gap-2 text-rose-700 font-black text-lg">
                                        <i class="fa-solid fa-circle-xmark"></i> Masalah Lapangan
                                    </div>
                                    <ul class="space-y-2 text-xs font-semibold text-slate-700 list-disc pl-4">
                                        <li>Masyarakat kesulitan membeli hewan Aqiqah & Qurban di luar musim Idul Adha.</li>
                                        <li>Proses pendaftaran & pemesanan aplikasi lama sering rumit dan wajib login.</li>
                                        <li>Kurangnya edukasi pemanfaatan lengkap seluruh bagian hewan (kulit, buntut, mata, kuku).</li>
                                        <li>Kekhawatiran akun admin penjual palsu / penipuan atas nama masjid.</li>
                                    </ul>
                                </div>

                                <div class="bg-emerald-50 p-6 rounded-2xl border-2 border-emerald-200 space-y-3">
                                    <div class="flex items-center gap-2 text-emerald-800 font-black text-lg">
                                        <i class="fa-solid fa-circle-check"></i> Solusi AqiqahKita
                                    </div>
                                    <ul class="space-y-2 text-xs font-semibold text-slate-700 list-disc pl-4">
                                        <li>Pemesanan fleksibel 365 hari untuk Aqiqah, Qurban, dan hajat harian.</li>
                                        <li>Pengunjung bisa leluasa browsing & chat langsung tanpa perlu login.</li>
                                        <li>Panduan anatomi interaktif 100% detail dari Kulit, Mata, Buntut, hingga Kuku.</li>
                                        <li>Sistem persetujuan ketat (Approval Workflow) oleh Super Admin sebelum DKM bisa jualan.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 3: SYSTEM ARCHITECTURE & ROLES -->
                    <template x-if="currentSlide === 2">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4">
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Arsitektur & Hak Akses</span>
                                <h2 class="text-3xl font-black font-heading text-slate-900">3 Peran Utama Pengguna</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-xl">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <h3 class="font-extrabold text-lg text-slate-900">Guest Visitor (Tamu)</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                        Browsing katalog, melihat detail hewan, menjelajahi diagram anatomi interaktif, dan mengirim live chat ke DKM tanpa mendaftar.
                                    </p>
                                </div>

                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl">
                                        <i class="fa-solid fa-mosque"></i>
                                    </div>
                                    <h3 class="font-extrabold text-lg text-slate-900">DKM Admin (Penyedia)</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                        Mengelola inventaris hewan (Kambing, Sapi, Domba), membalas pesan live chat jamaah, dan mengubah status ketersediaan.
                                    </p>
                                </div>

                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-black text-xl">
                                        <i class="fa-solid fa-user-shield"></i>
                                    </div>
                                    <h3 class="font-extrabold text-lg text-slate-900">Super Admin (Pusat)</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                        Memverifikasi & menyetujui (Approve/Reject) pendaftaran akun DKM Masjid baru serta memantau statistik platform.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 4: DESIGN SYSTEM & FIGMA TOKENS -->
                    <template x-if="currentSlide === 3">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4">
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">UI Design System & Visual Identity</span>
                                <h2 class="text-3xl font-black font-heading text-slate-900">Figma UI Kit & Design Tokens</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <h3 class="text-sm font-black text-slate-700 uppercase">Palet Warna Utama</h3>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="p-4 rounded-xl bg-emerald-600 text-white font-mono text-xs">
                                            <strong class="block text-sm font-sans font-black">Vibrant Emerald</strong>
                                            #059669
                                            <span class="block text-[10px] opacity-80 mt-1 font-sans">Primary Brand Header/Footer</span>
                                        </div>
                                        <div class="p-4 rounded-xl bg-amber-400 text-slate-950 font-mono text-xs">
                                            <strong class="block text-sm font-sans font-black">Sun Amber</strong>
                                            #F59E0B
                                            <span class="block text-[10px] opacity-80 mt-1 font-sans">CTA Buttons & Highlights</span>
                                        </div>
                                        <div class="p-4 rounded-xl bg-white border border-slate-300 text-slate-900 font-mono text-xs">
                                            <strong class="block text-sm font-sans font-black">Clean White</strong>
                                            #FFFFFF
                                            <span class="block text-[10px] opacity-60 mt-1 font-sans">Middle Body Background</span>
                                        </div>
                                        <div class="p-4 rounded-xl bg-slate-900 text-white font-mono text-xs">
                                            <strong class="block text-sm font-sans font-black">Dark Slate</strong>
                                            #0F172A
                                            <span class="block text-[10px] opacity-80 mt-1 font-sans">Dark Canvas & Modals</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h3 class="text-sm font-black text-slate-700 uppercase">Tipografi & Komponen UI</h3>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                                        <div><strong>Headings Font:</strong> <span class="font-heading text-lg font-black text-emerald-700">Outfit (Bold & Heavy)</span></div>
                                        <div><strong>Body Font:</strong> <span class="font-sans text-slate-700">Plus Jakarta Sans (Medium 14px)</span></div>
                                        <div><strong>Icon Library:</strong> FontAwesome 6.4.0 Free Pro</div>
                                        <div><strong>Interactive Framework:</strong> Alpine.js & Tailwind CSS v4</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 5: FEATURE SHOWCASE - INTERACTIVE ANATOMY -->
                    <template x-if="currentSlide === 4">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4">
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Fitur Unggulan #1</span>
                                <h2 class="text-3xl font-black font-heading text-slate-900">Anatomi & Pemanfaatan 100% Detail</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                <div class="space-y-3 text-xs text-slate-700 leading-relaxed font-medium">
                                    <p>
                                        Fitur anatomi interaktif memungkinkan calon pembeli mempelajari pemanfaatan setiap organ tubuh hewan secara mendalam:
                                    </p>
                                    <ul class="space-y-2 list-disc pl-4">
                                        <li><strong>Kulit & Wool:</strong> Rebana/Hadroh, Bedug Masjid Utama, Jaket Kulit, Rambak/Krecek, Wool Tekstil.</li>
                                        <li><strong>Mata & Otak:</strong> Soto Mata Khas Madura, Sup Bola Mata, Tengkleng Solo.</li>
                                        <li><strong>Buntut:</strong> Sop Buntut Rempah Jawa/Arabia, Buntut Bakar Madu.</li>
                                        <li><strong>Tanduk & Kuku:</strong> Sisir Tanduk, Gagang Pisau, Mie Kocok Kikil Kuku Sapi.</li>
                                        <li><strong>Daging & Jeroan:</strong> Sate, Rendang Padang, Sambal Goreng Hati Aqiqah.</li>
                                    </ul>
                                </div>

                                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 text-white space-y-3 shadow-lg">
                                    <div class="text-xs font-black text-amber-400 flex items-center justify-between">
                                        <span>🐐 Visual Target Hotspots Diagram</span>
                                        <span class="bg-amber-400/20 text-amber-300 text-[10px] px-2 py-0.5 rounded">13 Bagian</span>
                                    </div>
                                    <div class="relative aspect-video rounded-xl bg-slate-900 overflow-hidden border border-slate-800 flex items-center justify-center">
                                        <img src="{{ asset('images/sapi.jpg') }}" class="w-full h-full object-cover opacity-80">
                                        <div class="absolute top-1/4 left-1/5 w-6 h-6 rounded-full bg-amber-400 border border-white text-slate-950 text-[10px] font-black flex items-center justify-center pulse-hotspot">👁️</div>
                                        <div class="absolute top-1/3 right-1/8 w-6 h-6 rounded-full bg-amber-400 border border-white text-slate-950 text-[10px] font-black flex items-center justify-center pulse-hotspot">🍖</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 6: FEATURE SHOWCASE - GUEST CHAT & SECURITY APPROVAL -->
                    <template x-if="currentSlide === 5">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4">
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Fitur Unggulan #2 & #3</span>
                                <h2 class="text-3xl font-black font-heading text-slate-900">Live Chat Tamu & Super Admin Approval</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-200 space-y-3">
                                    <h3 class="font-extrabold text-base text-emerald-900 flex items-center gap-2">
                                        <i class="fa-solid fa-comments text-emerald-600"></i> Floating Live Chat Drawer
                                    </h3>
                                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                                        Pengunjung umum (tamu) dapat memilih DKM Masjid tujuan dan mengirim pertanyaan secara real-time. Pesan tersimpan otomatis via token sesi browser tanpa memerlukan login.
                                    </p>
                                </div>

                                <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 space-y-3">
                                    <h3 class="font-extrabold text-base text-amber-900 flex items-center gap-2">
                                        <i class="fa-solid fa-user-shield text-amber-600"></i> Keamanan Approval DKM
                                    </h3>
                                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                                        Setiap DKM Masjid baru yang mendaftar bernilai `is_approved = false` dan terblokir dari login. Super Admin wajib memverifikasi & menyetujui akun DKM sebelum bisa menjual hewan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE 7: LIVE PROTOTYPE VIEWER -->
                    <template x-if="currentSlide === 6">
                        <div class="space-y-6">
                            <div class="border-b border-slate-200 pb-4 flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Interactive Screen Prototype</span>
                                    <h2 class="text-3xl font-black font-heading text-slate-900">Uji Coba Tampilan Live</h2>
                                </div>
                                <a href="{{ route('home') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs px-4 py-2 rounded-xl shadow-md transition-all flex items-center gap-2">
                                    Buka Website Asli <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs font-extrabold">
                                <a href="{{ route('home') }}" target="_blank" class="p-4 bg-slate-100 hover:bg-emerald-50 rounded-2xl border border-slate-200 text-slate-800 text-center space-y-1 transition-all">
                                    <i class="fa-solid fa-desktop text-2xl text-emerald-600 block"></i>
                                    <span>Beranda Utama</span>
                                </a>
                                <a href="{{ route('anatomy.show', 'sapi') }}" target="_blank" class="p-4 bg-slate-100 hover:bg-emerald-50 rounded-2xl border border-slate-200 text-slate-800 text-center space-y-1 transition-all">
                                    <i class="fa-solid fa-bullseye text-2xl text-amber-500 block"></i>
                                    <span>Anatomi Sapi</span>
                                </a>
                                <a href="{{ route('login') }}" target="_blank" class="p-4 bg-slate-100 hover:bg-emerald-50 rounded-2xl border border-slate-200 text-slate-800 text-center space-y-1 transition-all">
                                    <i class="fa-solid fa-lock text-2xl text-emerald-600 block"></i>
                                    <span>Login Admin</span>
                                </a>
                                <a href="{{ route('register.dkm') }}" target="_blank" class="p-4 bg-slate-100 hover:bg-emerald-50 rounded-2xl border border-slate-200 text-slate-800 text-center space-y-1 transition-all">
                                    <i class="fa-solid fa-id-card text-2xl text-amber-500 block"></i>
                                    <span>Daftar DKM</span>
                                </a>
                            </div>
                        </div>
                    </template>

                    <!-- SLIDE FOOTER NAVIGATION -->
                    <div class="pt-6 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500 font-bold">
                        <span x-text="`Slide ${currentSlide + 1} dari ${slides.length}`"></span>
                        <div class="flex items-center gap-3">
                            <button @click="prevSlide()" :disabled="currentSlide === 0" class="disabled:opacity-40 text-slate-700 hover:text-emerald-700">
                                &larr; Slide Sebelumnya
                            </button>
                            <button @click="nextSlide()" :disabled="currentSlide === slides.length - 1" class="disabled:opacity-40 text-emerald-700 hover:text-emerald-900 font-black">
                                Slide Berikutnya &rarr;
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </main>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function figmaApp() {
        return {
            currentSlide: 0,
            presentMode: false,
            slides: [
                { title: 'Cover Proposal & Visi', shortTitle: 'Cover Visi AqiqahKita' },
                { title: 'Latar Belakang & Solusi', shortTitle: 'Latar Belakang & Solusi' },
                { title: 'Arsitektur Peran Pengguna', shortTitle: '3 Peran Pengguna' },
                { title: 'UI Design System Tokens', shortTitle: 'Figma UI Kit Tokens' },
                { title: 'Fitur Anatomi 100% Detail', shortTitle: 'Anatomi & Pemanfaatan' },
                { title: 'Live Chat & Security Approval', shortTitle: 'Chat & DKM Security' },
                { title: 'Uji Coba Screen Prototype', shortTitle: 'Live Screen Prototype' }
            ],
            nextSlide() {
                if (this.currentSlide < this.slides.length - 1) {
                    this.currentSlide++;
                }
            },
            prevSlide() {
                if (this.currentSlide > 0) {
                    this.currentSlide--;
                }
            }
        }
    }
</script>
@endpush
