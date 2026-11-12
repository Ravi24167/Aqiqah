@extends('layouts.app')

@section('title', 'AqiqahKita - Layanan Aqiqah, Qurban & Hewan Ternak Fleksibel')

@section('content')

<!-- HERO BANNER SECTION (VIBRANT RICH EMERALD GREEN TOP BANNER) -->
<section class="relative bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 text-white overflow-hidden py-16 lg:py-20 shadow-lg">
    <!-- Decorative background elements -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-xs md:text-sm font-extrabold uppercase tracking-wide border border-white/30">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-300 animate-ping"></span>
                    <i class="fa-solid fa-sparkles text-amber-300"></i> Platform Aqiqah & Qurban Bebas Ribet
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-heading leading-tight drop-shadow-md">
                    Pilihan Hewan Aqiqah & Qurban <span class="text-amber-300 underline decoration-amber-300/50 decoration-wavy">Fleksibel</span> Kapan Saja
                </h1>

                <p class="text-white text-base sm:text-lg leading-relaxed max-w-2xl font-medium">
                    Pesan Kambing, Sapi, atau Domba segar langsung dari DKM Masjid terdekat. Tanpa perlu login, tanpa menunggu hari raya. Dilengkapi panduan nutrisi & olahan lengkap!
                </p>

                <!-- Features Highlights -->
                <div class="grid grid-cols-3 gap-3 pt-2 max-w-xl">
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 border border-white/25 text-center">
                        <i class="fa-solid fa-user-shield text-amber-300 text-xl mb-1"></i>
                        <div class="text-xs font-bold">Tanpa Login</div>
                        <div class="text-[10px] text-white">Bebas Akses Tamu</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 border border-white/25 text-center">
                        <i class="fa-solid fa-calendar-check text-amber-300 text-xl mb-1"></i>
                        <div class="text-xs font-bold">Fleksibel 365 Hari</div>
                        <div class="text-[10px] text-white">Hari Biasa & Aqiqah</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 border border-white/25 text-center">
                        <i class="fa-solid fa-comments text-amber-300 text-xl mb-1"></i>
                        <div class="text-xs font-bold">Live Chat DKM</div>
                        <div class="text-[10px] text-white">Tanya Pengurus Langsung</div>
                    </div>
                </div>

                <!-- Call to action buttons -->
                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <a href="#catalog" class="bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-base px-8 py-4 rounded-2xl shadow-xl shadow-amber-400/30 hover:scale-105 transition-all flex items-center gap-3">
                        <i class="fa-solid fa-paw text-xl"></i> Lihat Hewan Tersedia
                    </a>
                    <a href="{{ route('anatomy.hub') }}" class="bg-white/20 hover:bg-white/30 text-white border border-white/40 font-bold text-base px-6 py-4 rounded-2xl transition-all flex items-center gap-2">
                        <i class="fa-solid fa-bullseye text-amber-300"></i> Cek Manfaat & Masakan
                    </a>
                </div>
            </div>

            <!-- Hero Image Banner Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative bg-white/20 backdrop-blur-md p-4 rounded-3xl border border-white/30 shadow-2xl">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative rounded-2xl overflow-hidden shadow-lg group">
                            <img src="{{ asset('images/kambing.jpg') }}" alt="Kambing Aqiqah" class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-3">
                                <span class="text-white font-bold text-sm">🐐 Kambing Aqiqah</span>
                            </div>
                        </div>
                        <div class="relative rounded-2xl overflow-hidden shadow-lg group">
                            <img src="{{ asset('images/sapi.jpg') }}" alt="Sapi Qurban" class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-3">
                                <span class="text-white font-bold text-sm">🐂 Sapi Qurban</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 relative rounded-2xl overflow-hidden shadow-lg group">
                        <img src="{{ asset('images/domba.jpg') }}" alt="Domba Garut" class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-3 justify-between">
                            <span class="text-white font-bold text-sm">🐑 Domba Garut Premium</span>
                            <span class="bg-amber-400 text-slate-950 text-xs font-black px-2.5 py-1 rounded-full">Tersedia Kapan Saja</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- INTERACTIVE ANIMAL BODY HOTSPOT SECTION (CLEAN WHITE MIDDLE BACKGROUND) -->
<section id="hotspot-section" class="py-16 bg-white relative overflow-hidden" x-data="hotspotApp()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 text-xs font-black uppercase px-3 py-1 rounded-full mb-3">
                <i class="fa-solid fa-bullseye text-amber-500"></i> Fitur Interaktif Anatomi Hewan
            </div>
            <h2 class="text-3xl sm:text-4xl font-black font-heading text-slate-900">
                Klik Bagian Tubuh Hewan Untuk Melihat <span class="text-emerald-600">Manfaat Nutrisi</span> & <span class="text-amber-500">Rekomendasi Masakan</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Pilih hewan di bawah ini, lalu klik titik buletan interaktif pada tubuh hewan untuk mengetahui kelezatan olahan dan khasiatnya!
            </p>

            <!-- Animal Selector Tabs -->
            <div class="flex justify-center items-center gap-3 mt-8">
                <button @click="selectAnimal('kambing')" :class="activeType === 'kambing' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 scale-105' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'" class="font-extrabold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 text-sm sm:text-base">
                    <span>🐐</span> Kambing
                </button>
                <button @click="selectAnimal('sapi')" :class="activeType === 'sapi' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 scale-105' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'" class="font-extrabold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 text-sm sm:text-base">
                    <span>🐂</span> Sapi
                </button>
                <button @click="selectAnimal('domba')" :class="activeType === 'domba' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 scale-105' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'" class="font-extrabold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 text-sm sm:text-base">
                    <span>🐑</span> Domba
                </button>
            </div>
        </div>

        <!-- Hotspot Graphic Container -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-white rounded-3xl p-6 lg:p-8 shadow-xl border-2 border-emerald-100">
            
            <!-- Left Side: Interactive Canvas / Hotspot Visual -->
            <div class="lg:col-span-7 relative flex justify-center items-center bg-slate-950 rounded-2xl p-4 overflow-hidden min-h-[380px] shadow-inner border-2 border-slate-800">
                <!-- Background Animal Visual -->
                <template x-if="activeType === 'kambing'">
                    <img src="{{ asset('images/kambing.jpg') }}" alt="Kambing Visual" class="w-full max-h-[360px] object-cover rounded-xl opacity-90">
                </template>
                <template x-if="activeType === 'sapi'">
                    <img src="{{ asset('images/sapi.jpg') }}" alt="Sapi Visual" class="w-full max-h-[360px] object-cover rounded-xl opacity-90">
                </template>
                <template x-if="activeType === 'domba'">
                    <img src="{{ asset('images/domba.jpg') }}" alt="Domba Visual" class="w-full max-h-[360px] object-cover rounded-xl opacity-90">
                </template>

                <!-- Hotspot Circles Overlay -->
                <template x-for="spot in currentHotspots" :key="spot.id">
                    <div :style="`top: ${spot.pos_y}%; left: ${spot.pos_x}%;`" class="absolute -translate-x-1/2 -translate-y-1/2 z-20 group">
                        <button @click="activeSpot = spot"
                                class="w-7 h-7 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 border border-white font-black text-[10px] flex items-center justify-center pulse-hotspot hover:scale-125 transition-transform z-20 shadow-lg cursor-pointer"
                                :class="activeSpot?.id === spot.id ? 'ring-4 ring-emerald-400 bg-amber-300 scale-125' : ''">
                            <i :class="'fa-solid ' + (spot.icon || 'fa-utensils')"></i>
                        </button>
                    </div>
                </template>

                <div class="absolute bottom-3 left-3 bg-slate-900/90 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span> Klik titik target di gambar hewan
                </div>
            </div>

            <!-- Right Side: Hotspot Information Card -->
            <div class="lg:col-span-5 bg-emerald-50/50 rounded-2xl p-6 border-2 border-emerald-100 shadow-sm min-h-[380px] flex flex-col justify-between">
                <template x-if="activeSpot">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-emerald-200 pb-3">
                            <span class="text-xs font-black uppercase tracking-wider text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                                Bagian Terpilih
                            </span>
                            <span class="text-xs text-amber-700 font-bold">
                                <i class="fa-solid fa-sparkles"></i> Pemanfaatan Lengkap
                            </span>
                        </div>

                        <h3 class="text-2xl font-black font-heading text-slate-900 flex items-center gap-2" x-text="activeSpot.body_part"></h3>

                        <!-- Utilization -->
                        <template x-if="activeSpot.utilization_details">
                            <div class="bg-amber-50 p-3.5 rounded-xl border border-amber-200 shadow-sm">
                                <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-drum text-amber-600"></i> Pemanfaatan Kulit & Kerajinan
                                </h4>
                                <p class="text-xs text-slate-800 font-extrabold leading-relaxed" x-text="activeSpot.utilization_details"></p>
                            </div>
                        </template>

                        <!-- Health & Nutrition Benefits -->
                        <div class="bg-white p-3.5 rounded-xl border border-emerald-100 shadow-sm">
                            <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-heart-pulse text-rose-500"></i> Manfaat Kesehatan & Nutrisi
                            </h4>
                            <p class="text-xs text-slate-700 font-medium leading-relaxed" x-text="activeSpot.benefits"></p>
                        </div>

                        <!-- Recommended Dishes / Recipes -->
                        <div class="bg-white p-3.5 rounded-xl border border-emerald-100 shadow-sm">
                            <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wide mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-fire-burner text-amber-600"></i> Enak Dimasak & Olahan Kuliner
                            </h4>
                            <p class="text-xs text-slate-900 font-black leading-relaxed" x-text="activeSpot.recommended_recipes"></p>
                        </div>
                    </div>
                </template>

                <template x-if="!activeSpot">
                    <div class="flex flex-col items-center justify-center text-center h-full py-12 text-slate-400 space-y-3">
                        <i class="fa-solid fa-hand-pointer text-4xl text-amber-400 animate-bounce"></i>
                        <p class="text-sm font-bold text-slate-600">Silakan klik salah satu titik target di gambar hewan di samping!</p>
                    </div>
                </template>

                <div class="pt-4 border-t border-emerald-100 flex items-center justify-between text-xs text-slate-500">
                    <a href="{{ route('anatomy.hub') }}" class="text-emerald-700 font-bold hover:underline">
                        Lihat Halaman Detail Anatomi Lengkap &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- LIVESTOCK CATALOG SECTION (CLEAN WHITE BACKGROUND) -->
<section id="catalog" class="py-16 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <span class="text-xs font-black uppercase text-amber-700 tracking-wider bg-amber-100 px-3 py-1 rounded-full">
                    Katalog Kurban & Aqiqah
                </span>
                <h2 class="text-3xl sm:text-4xl font-black font-heading text-slate-900 mt-2">
                    Daftar Hewan Siap Kirim Hari Ini
                </h2>
                <p class="text-slate-600 text-sm mt-1">Bisa dibeli kapan saja untuk Aqiqah, Kurban Idul Adha, atau kebutuhan harian.</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-2">
                <!-- Category Filters -->
                <a href="{{ route('home', ['category' => 'all', 'type' => request('type', 'all')]) }}#catalog" 
                   class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ request('category', 'all') === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                   Semua Kategori
                </a>
                <a href="{{ route('home', ['category' => 'aqiqah', 'type' => request('type', 'all')]) }}#catalog" 
                   class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ request('category') === 'aqiqah' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                   ✨ Aqiqah
                </a>
                <a href="{{ route('home', ['category' => 'qurban', 'type' => request('type', 'all')]) }}#catalog" 
                   class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ request('category') === 'qurban' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                   🕌 Kurban
                </a>
                <a href="{{ route('home', ['category' => 'harian', 'type' => request('type', 'all')]) }}#catalog" 
                   class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ request('category') === 'harian' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                   📅 Harian (Bebas)
                </a>
            </div>
        </div>

        <!-- Animal Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ selectedAnimal: null }">
            @forelse($animals as $animal)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Image Container -->
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            <img src="{{ asset($animal->image ?: 'images/kambing.jpg') }}" alt="{{ $animal->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-4 left-4 flex flex-col gap-1">
                                <span class="bg-emerald-600 text-white text-[11px] font-black uppercase px-3 py-1 rounded-full shadow-md">
                                    {{ strtoupper($animal->type) }}
                                </span>
                                <span class="bg-amber-500 text-slate-900 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow-md">
                                    {{ strtoupper($animal->category) }}
                                </span>
                            </div>

                            <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-xl border border-white/20">
                                ⚖️ {{ $animal->weight_kg }} kg
                            </div>
                        </div>

                        <!-- Info Content -->
                        <div class="p-6 space-y-3">
                            <!-- DKM Mosque badge -->
                            <div class="flex items-center gap-2 text-xs font-extrabold text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-100 inline-flex">
                                <i class="fa-solid fa-mosque"></i> {{ $animal->user->masjid_name ?? 'DKM Masjid' }}
                            </div>

                            <h3 class="text-xl font-extrabold font-heading text-slate-900 line-clamp-1">
                                {{ $animal->name }}
                            </h3>

                            <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed">
                                {{ $animal->description }}
                            </p>

                            <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs font-bold text-slate-500">
                                <span>Jenis Kelamin: <strong class="text-slate-800">{{ $animal->gender }}</strong></span>
                                <span class="text-emerald-700 font-extrabold">✓ Bebas Penyakit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer & Price -->
                    <div class="p-6 pt-0 space-y-3">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-bold text-slate-400">Harga Terjangkau</span>
                            <span class="text-2xl font-black font-heading text-emerald-700">
                                {{ $animal->formatted_price }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button @click="openModal({{ $animal->id }})" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold text-xs py-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-circle-info"></i> Detail Hewan
                            </button>
                            <button @click="openChatWithDkm({{ $animal->user_id }}, '{{ addslashes($animal->user->masjid_name ?? 'DKM Admin') }}', 'Halo DKM, saya mau tanya paket hewan {{ addslashes($animal->name) }} ({{ $animal->formatted_price }})...')" 
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs py-3 rounded-xl transition-all shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-comments"></i> Tanya DKM
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                    <i class="fa-solid fa-paw text-4xl text-slate-300 mb-3"></i>
                    <p class="text-slate-600 font-bold">Belum ada hewan ternak untuk kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- DKM MASJID PARTNERS SECTION (VIBRANT EMERALD GREEN) -->
<section id="dkm-section" class="py-16 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 text-white shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-black uppercase tracking-wider text-slate-950 bg-amber-400 px-3.5 py-1 rounded-full shadow-md">
                Mitra DKM Masjid Terpercaya
            </span>
            <h2 class="text-3xl sm:text-4xl font-black font-heading mt-3">
                Terhubung Langsung Dengan Pengurus DKM Masjid
            </h2>
            <p class="text-white text-sm sm:text-base mt-2 font-medium">
                Penyembelihan syar'i, pemotongan higienis, dan pendistribusian daging amanah langsung dikelola oleh DKM Masjid terdaftar.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dkms as $dkm)
                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/25 flex flex-col justify-between space-y-4 hover:bg-white/25 transition-all">
                    <div>
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-white text-emerald-700 flex items-center justify-center text-2xl font-black shadow-md">
                                <i class="fa-solid fa-mosque"></i>
                            </div>
                            <span class="bg-white/25 text-white text-[10px] font-black px-2.5 py-1 rounded-full border border-white/30">
                                ✓ DKM Terverifikasi
                            </span>
                        </div>
                        <h3 class="text-xl font-bold font-heading mt-3 text-white">{{ $dkm->masjid_name }}</h3>
                        <p class="text-white/90 text-xs mt-1 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-location-dot text-amber-300"></i> {{ $dkm->address }}
                        </p>
                        <p class="text-white/90 text-xs mt-1 flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-user-tie text-amber-300"></i> Penanggung Jawab: {{ $dkm->name }}
                        </p>
                    </div>

                    <button @click="openChatWithDkm({{ $dkm->id }}, '{{ addslashes($dkm->masjid_name) }}')" 
                            class="w-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs py-3 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
                        <i class="fa-solid fa-comments"></i> Chat DKM Masjid Ini
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ANIMAL DETAIL MODAL -->
<div id="animalModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative border border-emerald-100 max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div id="modalContent" class="space-y-6">
            <div class="text-center py-8">
                <i class="fa-solid fa-circle-notch fa-spin text-3xl text-emerald-600"></i>
                <p class="text-xs text-slate-500 mt-2">Memuat detail hewan...</p>
            </div>
        </div>
    </div>
</div>

<!-- FLOATING LIVE CHAT DRAWER (GUEST TO DKM MASJID) -->
<div x-data="guestChatApp()" class="fixed bottom-6 right-6 z-50">
    <button @click="toggleChat()" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold px-5 py-3.5 rounded-full shadow-2xl flex items-center gap-3 transition-transform hover:scale-105 border-2 border-white">
        <div class="relative">
            <i class="fa-solid fa-comments text-xl"></i>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-amber-400 rounded-full border-2 border-emerald-600 animate-ping"></span>
        </div>
        <span class="text-sm font-heading hidden sm:inline">Tanya DKM Masjid</span>
    </button>

    <div x-show="isOpen" x-transition class="fixed bottom-24 right-6 w-96 max-w-[calc(100vw-3rem)] bg-white rounded-3xl shadow-2xl border border-emerald-200 overflow-hidden flex flex-col h-[520px] chat-shadow z-50">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-amber-300 font-bold">
                    <i class="fa-solid fa-mosque"></i>
                </div>
                <div>
                    <h4 class="font-extrabold font-heading text-sm text-white" x-text="selectedDkmName || 'Chat DKM Masjid'"></h4>
                    <p class="text-[10px] text-emerald-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Respons Cepat Tanpa Login
                    </p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-white/80 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-3 bg-emerald-50/60 border-b border-emerald-100">
            <label class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Pilih DKM Masjid Tujuan:</label>
            <select x-model="selectedDkmId" @change="onDkmChange()" class="w-full text-xs font-bold bg-white border border-emerald-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">-- Pilih Masjid --</option>
                @foreach($dkms as $dkm)
                    <option value="{{ $dkm->id }}">{{ $dkm->masjid_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-grow p-4 overflow-y-auto space-y-3 bg-white" id="guestChatMessages">
            <template x-if="!selectedDkmId">
                <div class="text-center py-12 text-slate-400 space-y-2">
                    <i class="fa-solid fa-comments text-3xl text-emerald-300"></i>
                    <p class="text-xs font-bold text-slate-600">Pilih DKM Masjid di atas untuk memulai percakapan!</p>
                </div>
            </template>

            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.sender_type === 'guest' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender_type === 'guest' ? 'bg-emerald-600 text-white rounded-2xl rounded-tr-none' : 'bg-slate-100 border border-slate-200 text-slate-800 rounded-2xl rounded-tl-none shadow-sm'" 
                         class="max-w-[80%] p-3 text-xs space-y-1">
                        <p x-text="msg.message" class="leading-relaxed font-medium"></p>
                        <span :class="msg.sender_type === 'guest' ? 'text-emerald-200' : 'text-slate-400'" class="text-[9px] block text-right font-bold" x-text="formatTime(msg.created_at)"></span>
                    </div>
                </div>
            </template>
        </div>

        <div class="p-3 bg-white border-t border-slate-100 flex items-center gap-2">
            <input type="text" x-model="newMessage" @keyup.enter="sendMsg()" placeholder="Tulis pertanyaan Anda..." :disabled="!selectedDkmId"
                   class="flex-grow text-xs px-4 py-2.5 bg-slate-100 rounded-xl font-medium border border-transparent focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500 disabled:opacity-50">
            <button @click="sendMsg()" :disabled="!selectedDkmId || !newMessage.trim()" class="bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 text-white w-9 h-9 rounded-xl flex items-center justify-center shadow-md transition-all">
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function hotspotApp() {
        return {
            activeType: 'kambing',
            currentHotspots: @json($kambingHotspots),
            activeSpot: null,
            allHotspots: {
                kambing: @json($kambingHotspots),
                sapi: @json($sapiHotspots),
                domba: @json($dombaHotspots)
            },
            init() {
                if (this.currentHotspots.length > 0) {
                    this.activeSpot = this.currentHotspots[0];
                }
            },
            selectAnimal(type) {
                this.activeType = type;
                this.currentHotspots = this.allHotspots[type] || [];
                this.activeSpot = this.currentHotspots.length > 0 ? this.currentHotspots[0] : null;
            }
        }
    }

    function openModal(id) {
        document.getElementById('animalModal').classList.remove('hidden');
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="text-center py-8">
                <i class="fa-solid fa-circle-notch fa-spin text-3xl text-emerald-600"></i>
                <p class="text-xs text-slate-500 mt-2">Memuat detail hewan...</p>
            </div>
        `;

        fetch(`/api/animal/${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const animal = data.animal;
                    modalContent.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                            <img src="${animal.image}" class="w-full h-64 object-cover rounded-2xl shadow-md border border-slate-200">
                            <div class="space-y-3">
                                <div class="flex gap-2">
                                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-0.5 rounded-full">${animal.type}</span>
                                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-0.5 rounded-full">${animal.category}</span>
                                </div>
                                <h3 class="text-2xl font-black font-heading text-slate-900">${animal.name}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed">${animal.description}</p>
                                
                                <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-1 text-xs font-bold text-slate-700">
                                    <div>⚖️ Berat: <span class="text-emerald-700">${animal.weight_kg} kg</span></div>
                                    <div>♂️ Jenis Kelamin: <span class="text-slate-900">${animal.gender}</span></div>
                                    <div>🕌 Pengelola: <span class="text-emerald-700">${animal.masjid_name}</span></div>
                                </div>

                                <div class="text-2xl font-black font-heading text-emerald-600">${animal.price_formatted}</div>

                                <div class="pt-2">
                                    <button onclick="closeModal(); window.openChatWithDkmGlobal(${animal.dkm_id}, '${animal.masjid_name}', 'Halo DKM, saya berminat pesan paket ${animal.name} (${animal.price_formatted})')" 
                                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs py-3 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-comments"></i> Tanya & Pesan Langsung ke DKM
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
    }

    function closeModal() {
        document.getElementById('animalModal').classList.add('hidden');
    }

    function guestChatApp() {
        return {
            isOpen: false,
            guestToken: '',
            guestSignature: '',
            selectedDkmId: '',
            selectedDkmName: '',
            messages: [],
            newMessage: '',
            pollInterval: null,

            async ensureGuestToken() {
                let token = localStorage.getItem('aqiqah_guest_token');
                let signature = localStorage.getItem('aqiqah_guest_sig');
                if (!token || !signature) {
                    try {
                        const res = await fetch('/api/chat/guest-token');
                        const data = await res.json();
                        if (data.success) {
                            token = data.guest_token;
                            signature = data.signature;
                            localStorage.setItem('aqiqah_guest_token', token);
                            localStorage.setItem('aqiqah_guest_sig', signature);
                        }
                    } catch (e) {
                        console.error('Gagal memuat token tamu', e);
                    }
                }
                this.guestToken = token || '';
                this.guestSignature = signature || '';
            },

            async init() {
                await this.ensureGuestToken();

                window.openChatWithDkmGlobal = (dkmId, dkmName, initialMsg = '') => {
                    this.selectedDkmId = dkmId;
                    this.selectedDkmName = dkmName;
                    this.isOpen = true;
                    this.fetchMessages();

                    if (initialMsg) {
                        this.newMessage = initialMsg;
                    }
                };
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen && this.selectedDkmId) {
                    this.fetchMessages();
                    this.startPolling();
                }
            },

            onDkmChange() {
                const select = event.target;
                this.selectedDkmName = select.options[select.selectedIndex].text;
                this.fetchMessages();
                this.startPolling();
            },

            fetchMessages() {
                if (!this.selectedDkmId) return;

                fetch(`/api/chat/messages?guest_token=${this.guestToken}&signature=${this.guestSignature}&dkm_id=${this.selectedDkmId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.messages = data.messages;
                            this.scrollToBottom();
                        }
                    });
            },

            sendMsg() {
                if (!this.newMessage.trim() || !this.selectedDkmId) return;

                const text = this.newMessage;
                this.newMessage = '';

                fetch('/api/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guest_token: this.guestToken,
                        signature: this.guestSignature,
                        guest_name: 'Tamu Penanya',
                        dkm_id: this.selectedDkmId,
                        message: text
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.scrollToBottom();
                    }
                });
            },

            startPolling() {
                if (this.pollInterval) clearInterval(this.pollInterval);
                this.pollInterval = setInterval(() => {
                    if (this.isOpen && this.selectedDkmId) {
                        this.fetchMessages();
                    }
                }, 4000);
            },

            scrollToBottom() {
                setTimeout(() => {
                    const el = document.getElementById('guestChatMessages');
                    if (el) el.scrollTop = el.scrollHeight;
                }, 100);
            },

            formatTime(datetime) {
                if (!datetime) return '';
                const date = new Date(datetime);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }
    }

    function openChatWithDkm(dkmId, dkmName, msg = '') {
        if (window.openChatWithDkmGlobal) {
            window.openChatWithDkmGlobal(dkmId, dkmName, msg);
        }
    }
</script>
@endpush
