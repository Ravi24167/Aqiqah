@extends('layouts.app')

@section('title', 'Pusat Anatomi & Pemanfaatan Hewan Ternak - AqiqahKita')

@section('content')
<div class="bg-white min-h-[85vh]">
    <section class="relative bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 text-white overflow-hidden py-12 sm:py-16 shadow-lg">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto space-y-5 text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-xs sm:text-sm font-extrabold uppercase tracking-wide border border-white/30">
                    <i class="fa-solid fa-layer-group text-amber-300"></i> Panduan Lengkap Hewan Ternak
                </div>
                <h1 class="text-3xl sm:text-5xl font-black font-heading leading-tight">
                    Pilih Hewan Untuk Mempelajari <span class="text-amber-300">Anatomi & Pemanfaatannya</span>
                </h1>
                <p class="text-white text-sm sm:text-base leading-relaxed max-w-3xl mx-auto font-medium">
                    Kenali bagian tubuh kambing, sapi, dan domba serta ragam pemanfaatannya, dari kulit dan tanduk hingga berbagai olahan daging.
                </p>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <!-- 3 Animal Dedicated Cards (CLEAN WHITE MIDDLE BACKGROUND) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- KAMBING CARD -->
            <div class="bg-white rounded-3xl overflow-hidden border-2 border-slate-200 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="relative h-64 overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/kambing.jpg') }}" alt="Kambing" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-90">
                        <div class="absolute top-4 left-4">
                            <span class="bg-amber-400 text-slate-900 text-xs font-black uppercase px-3 py-1 rounded-full shadow-md">
                                🐐 Anatomi Kambing
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 bg-slate-900/80 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-white">
                            <div class="text-xs font-bold flex items-center gap-1.5 text-amber-300">
                                <i class="fa-solid fa-sparkles"></i> Pemanfaatan Terpopuler:
                            </div>
                            <div class="text-[11px] text-slate-200 mt-1">
                                Rebana, Bedug Masjid, Tengkleng, Tongseng, Sate Kambing.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <h3 class="text-2xl font-black font-heading text-slate-900">Anatomi & Pemanfaatan Kambing</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Penjelasan rinci pengolahan kulit kambing untuk alat musik islami & kerupuk rambak, sup mata/kepala, hingga buntut & iga.
                        </p>

                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Kulit & Rebana</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Mata & Otak</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Buntut Rempah</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Tanduk Kerajinan</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('anatomy.show', 'kambing') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs py-3.5 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <span>Buka Halaman Detail Kambing</span> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- SAPI CARD -->
            <div class="bg-white rounded-3xl overflow-hidden border-2 border-slate-200 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="relative h-64 overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/sapi.jpg') }}" alt="Sapi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-90">
                        <div class="absolute top-4 left-4">
                            <span class="bg-emerald-600 text-white text-xs font-black uppercase px-3 py-1 rounded-full shadow-md">
                                🐂 Anatomi Sapi
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 bg-slate-900/80 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-white">
                            <div class="text-xs font-bold flex items-center gap-1.5 text-amber-300">
                                <i class="fa-solid fa-sparkles"></i> Pemanfaatan Terpopuler:
                            </div>
                            <div class="text-[11px] text-slate-200 mt-1">
                                Bedug Masjid Utama, Sepatu/Jaket Kulit, Sop Buntut, Rendang, Bakso.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <h3 class="text-2xl font-black font-heading text-slate-900">Anatomi & Pemanfaatan Sapi</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Detail olahan kulit sapi untuk Bedug & Kerupuk Rambak, Sop Buntut legendaris, kikil mata, dan potongan daging berkelas.
                        </p>

                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Kulit Bedug Utama</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Sop Buntut Luxe</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Mata & Rawon</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Kikil Kuku</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('anatomy.show', 'sapi') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs py-3.5 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <span>Buka Halaman Detail Sapi</span> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- DOMBA CARD -->
            <div class="bg-white rounded-3xl overflow-hidden border-2 border-slate-200 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="relative h-64 overflow-hidden bg-slate-900">
                        <img src="{{ asset('images/domba.jpg') }}" alt="Domba" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-90">
                        <div class="absolute top-4 left-4">
                            <span class="bg-amber-500 text-slate-900 text-xs font-black uppercase px-3 py-1 rounded-full shadow-md">
                                🐑 Anatomi Domba
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 bg-slate-900/80 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-white">
                            <div class="text-xs font-bold flex items-center gap-1.5 text-amber-300">
                                <i class="fa-solid fa-sparkles"></i> Pemanfaatan Terpopuler:
                            </div>
                            <div class="text-[11px] text-slate-200 mt-1">
                                Wool Pakaian, Tanduk Ukir Garut, Nasi Kebuli, Sate Klatak.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <h3 class="text-2xl font-black font-heading text-slate-900">Anatomi & Pemanfaatan Domba</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Rincian serat Wool domba untuk tekstil, tanduk indah untuk hiasan & sisir, sup mata, buntut manis, dan daging juicy.
                        </p>

                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Wool Tekstil</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Tanduk Seni Garut</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Nasi Kebuli</span>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-100">Buntut Rempah</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('anatomy.show', 'domba') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs py-3.5 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <span>Buka Halaman Detail Domba</span> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
