@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="py-6 sm:py-10 bg-white min-h-[90vh]" x-data="anatomyDetailApp()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
        
        <!-- Navigation Breadcrumb & Fine-Tuner Switch -->
        <div class="flex flex-wrap items-center justify-between text-xs font-bold text-slate-500 gap-2">
            <div class="flex items-center gap-1.5 sm:gap-2">
                <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
                <span>/</span>
                <a href="{{ route('anatomy.hub') }}" class="hover:text-emerald-600">Pusat Anatomi</a>
                <span>/</span>
                <span class="text-emerald-700 uppercase font-black">{{ $type }}</span>
            </div>

            <!-- Switch Animal quick buttons -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                <button @click="devMode = !devMode" 
                        :class="devMode ? 'bg-amber-500 text-slate-900 border-amber-400 font-black' : 'bg-white text-slate-600 border-slate-200'"
                        class="px-2.5 py-1.5 rounded-xl text-[11px] sm:text-xs border transition-all flex items-center gap-1 shadow-sm shrink-0">
                    <i class="fa-solid fa-crosshairs"></i> <span x-text="devMode ? 'Mode Kalibrasi Aktif' : 'Atur Presisi'"></span>
                </button>
                
                <a href="{{ route('anatomy.show', 'kambing') }}" class="px-2.5 py-1.5 rounded-xl font-black text-[11px] sm:text-xs transition-all shrink-0 {{ $type === 'kambing' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">🐐 Kambing</a>
                <a href="{{ route('anatomy.show', 'sapi') }}" class="px-2.5 py-1.5 rounded-xl font-black text-[11px] sm:text-xs transition-all shrink-0 {{ $type === 'sapi' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">🐂 Sapi</a>
                <a href="{{ route('anatomy.show', 'domba') }}" class="px-2.5 py-1.5 rounded-xl font-black text-[11px] sm:text-xs transition-all shrink-0 {{ $type === 'domba' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">🐑 Domba</a>
            </div>
        </div>

        <!-- Page Header Banner -->
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-12 -bottom-12 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-3xl space-y-2 sm:space-y-3 relative z-10">
                <div class="inline-flex items-center gap-2 bg-amber-400 text-slate-950 text-[10px] sm:text-xs font-black uppercase px-3 py-1 rounded-full">
                    <i class="fa-solid fa-bullseye"></i> Diagram Presisi 100% {{ strtoupper($type) }}
                </div>
                <h1 class="text-2xl sm:text-4xl font-black font-heading leading-tight">
                    Pemanfaatan Lengkap <span class="text-amber-300">Kulit</span>, <span class="text-amber-300">Mata</span>, <span class="text-amber-300">Buntut</span> & <span class="text-white">Daging {{ ucfirst($type) }}</span>
                </h1>
                <p class="text-white text-xs sm:text-sm leading-relaxed font-medium">
                    Setiap titik menunjukkan bagian tubuh {{ $type }}. Klik titik pada gambar untuk melihat rincian olahan dan pemanfaatannya.
                </p>
            </div>
        </div>

        <!-- Calibration Mode Helper Warning -->
        <div x-show="devMode" x-transition class="bg-amber-500/20 border-2 border-amber-400 p-3 sm:p-4 rounded-2xl text-slate-900 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2 shadow-md">
            <div class="flex items-start sm:items-center gap-2">
                <i class="fa-solid fa-crosshairs text-amber-600 text-lg shrink-0 mt-0.5 sm:mt-0"></i>
                <div>
                    <strong class="font-extrabold text-xs sm:text-sm block">Mode Kalibrasi Presisi Titik Aktif!</strong>
                    Pilih salah satu bagian tubuh di kanan, lalu klik gambar untuk menempatkan titik pada bagian yang diinginkan.
                </div>
            </div>
            <button @click="devMode = false" class="bg-slate-900 text-white font-bold text-xs px-3 py-1.5 rounded-xl self-end sm:self-auto">Selesai</button>
        </div>

        <!-- Category Filter Tabs (Mobile Scrollable) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
                <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3.5 py-2 rounded-xl text-xs font-black transition-all shrink-0">
                    🔍 Semua Bagian ({{ count($hotspots) }})
                </button>
                <button @click="activeFilter = 'kerajinan'" :class="activeFilter === 'kerajinan' ? 'bg-amber-400 text-slate-950 shadow-md font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold'" class="px-3.5 py-2 rounded-xl text-xs transition-all shrink-0">
                    🪘 Kulit & Industri
                </button>
                <button @click="activeFilter = 'kuliner'" :class="activeFilter === 'kuliner' ? 'bg-emerald-600 text-white shadow-md font-black' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold'" class="px-3.5 py-2 rounded-xl text-xs transition-all shrink-0">
                    🍲 Olahan Kuliner Khas
                </button>
            </div>

            <div class="text-[11px] sm:text-xs text-slate-500 font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Klik titik target kecil pada gambar hewan</span>
            </div>
        </div>

        <!-- Main Interactive Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start bg-white rounded-3xl">
            
            <!-- Left Side: Interactive Graphic Canvas with Aspect Ratio Locked -->
            <div class="lg:col-span-7 bg-slate-950 rounded-3xl p-3 sm:p-5 shadow-2xl relative border-2 sm:border-4 border-slate-800 flex flex-col justify-between">
                
                <!-- Background Image Canvas -->
                <div @click="onCanvasClick($event)" class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-inner bg-slate-900 border border-slate-800 cursor-crosshair">
                    <img src="{{ asset('images/' . $type . '.jpg') }}" alt="{{ $type }}" class="w-full h-full object-cover opacity-90 select-none">

                    <!-- Hotspot Circles (Touch Friendly Target Pins) -->
                    <template x-for="spot in filteredHotspots" :key="spot.id">
                        <div :style="`top: ${spot.pos_y}%; left: ${spot.pos_x}%;`" class="absolute -translate-x-1/2 -translate-y-1/2 z-20 group">
                            
                            <!-- Target Circle Button -->
                            <button @click.stop="selectSpot(spot)"
                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 border border-white font-black text-[10px] sm:text-xs flex items-center justify-center pulse-hotspot hover:scale-125 transition-all shadow-xl cursor-pointer"
                                    :aria-label="'Lihat ' + spot.body_part"
                                    :aria-pressed="activeSpot?.id === spot.id"
                                    :class="activeSpot?.id === spot.id ? 'ring-4 ring-emerald-400 bg-amber-300 scale-125 z-30' : ''">
                                <i :class="'fa-solid ' + (spot.icon || 'fa-utensils')"></i>
                            </button>

                            <div x-show="activeSpot?.id === spot.id" x-transition.opacity
                                 class="absolute whitespace-nowrap bg-slate-950/95 text-amber-300 text-[9px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-md border border-amber-400 ring-1 ring-amber-400 shadow-xl pointer-events-none backdrop-blur-sm flex items-center gap-1 z-30"
                                 :class="getLabelPositionClass(spot)">
                                <span x-text="spot.body_part"></span>
                            </div>

                        </div>
                    </template>
                </div>

                <!-- Canvas Bottom Bar -->
                <div class="mt-3 flex items-center justify-between text-[11px] sm:text-xs text-slate-300 bg-white/10 backdrop-blur-md px-3 sm:px-4 py-2 rounded-xl border border-white/15">
                    <span class="flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-crosshairs text-amber-400"></i>
                        <span>Pilih titik pada gambar {{ $type }} untuk melihat bagian tubuh dan pemanfaatannya.</span>
                    </span>
                    <span class="font-bold text-amber-300 shrink-0" x-text="filteredHotspots.length + ' Titik'"></span>
                </div>

            </div>

            <!-- Right Side: Detailed Body Part Breakdown Card -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-5 sm:p-7 shadow-xl border-2 border-emerald-100 flex flex-col justify-between min-h-[420px]">
                
                <template x-if="activeSpot">
                    <div class="space-y-4 sm:space-y-5">
                        
                        <!-- Header Title Part -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3 sm:pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg sm:text-xl shadow-md shrink-0">
                                    <i :class="'fa-solid ' + (activeSpot.icon || 'fa-utensils')"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-black font-heading text-slate-900" x-text="activeSpot.body_part"></h3>
                                    <span class="text-[9px] sm:text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full inline-block"
                                          :class="activeSpot.part_category === 'kerajinan' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900'">
                                        <i class="fa-solid fa-tag"></i> <span x-text="activeSpot.part_category === 'kerajinan' ? 'Kulit, Tanduk & Industri' : 'Kuliner & Kesehatan'"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Live Fine Tuner Controls (If Dev Mode is ON) -->
                            <template x-if="devMode">
                                <div class="bg-amber-100 p-1.5 rounded-xl border border-amber-300 text-[9px] font-bold space-y-1 text-right shrink-0">
                                    <div><span class="text-amber-900 font-extrabold" x-text="`X:${activeSpot.pos_x}%, Y:${activeSpot.pos_y}%`"></span></div>
                                    <div class="flex gap-1 justify-end">
                                        <button @click="nudgePin(0, -1)" class="w-5 h-5 bg-amber-400 rounded text-slate-900 font-black">⬆</button>
                                        <button @click="nudgePin(0, 1)" class="w-5 h-5 bg-amber-400 rounded text-slate-900 font-black">⬇</button>
                                        <button @click="nudgePin(-1, 0)" class="w-5 h-5 bg-amber-400 rounded text-slate-900 font-black">⬅</button>
                                        <button @click="nudgePin(1, 0)" class="w-5 h-5 bg-amber-400 rounded text-slate-900 font-black">➡️</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- 1. Craft / Leather / Industrial Utilization -->
                        <template x-if="activeSpot.utilization_details">
                            <div class="bg-amber-50 p-3.5 sm:p-4 rounded-2xl border border-amber-200 space-y-1 shadow-sm">
                                <h4 class="text-[11px] sm:text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-drum text-amber-600"></i> Pemanfaatan Kulit & Industri:
                                </h4>
                                <p class="text-xs text-slate-800 font-bold leading-relaxed" x-text="activeSpot.utilization_details"></p>
                            </div>
                        </template>

                        <!-- 2. Culinary Recipes -->
                        <div class="bg-emerald-50 p-3.5 sm:p-4 rounded-2xl border border-emerald-100 space-y-1 shadow-sm">
                            <h4 class="text-[11px] sm:text-xs font-black text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-fire-burner text-emerald-600"></i> Rekomendasi Olahan & Masakan:
                            </h4>
                            <p class="text-xs text-slate-900 font-extrabold leading-relaxed" x-text="activeSpot.recommended_recipes"></p>
                        </div>

                        <!-- 3. Health & Nutritional Benefits -->
                        <div class="bg-slate-50 p-3.5 sm:p-4 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                            <h4 class="text-[11px] sm:text-xs font-black text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-heart-pulse text-rose-500"></i> Khasiat & Manfaat Nutrisi:
                            </h4>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed" x-text="activeSpot.benefits"></p>
                        </div>

                    </div>
                </template>

                <template x-if="!activeSpot">
                    <div class="text-center py-12 sm:py-16 text-slate-400 space-y-3">
                        <i class="fa-solid fa-hand-pointer text-3xl sm:text-4xl text-amber-400 animate-bounce"></i>
                        <p class="text-xs sm:text-sm font-bold text-slate-600">Klik salah satu titik target di gambar hewan!</p>
                    </div>
                </template>

                <!-- Action CTA -->
                <div class="pt-4 sm:pt-6 border-t border-slate-100 mt-4 sm:mt-6 flex items-center justify-between gap-2">
                    <span class="text-[11px] sm:text-xs text-slate-500 font-bold">Pesan paket {{ $type }}?</span>
                    <a href="{{ route('home') }}#catalog" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-1.5 shrink-0">
                        <i class="fa-solid fa-paw"></i> Lihat Katalog
                    </a>
                </div>

            </div>

        </div>

        <!-- Full List of All Body Parts Grid -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4 sm:space-y-6">
            <h3 class="text-xl sm:text-2xl font-black font-heading text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-600"></i> Seluruh Rincian Bagian {{ ucfirst($type) }}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <template x-for="spot in filteredHotspots" :key="'list_' + spot.id">
                    <div @click="selectSpot(spot)" 
                         :class="activeSpot?.id === spot.id ? 'border-emerald-500 bg-emerald-50/60 shadow-md ring-2 ring-emerald-400' : 'border-slate-200 hover:border-emerald-300 bg-white hover:bg-slate-50'"
                         class="p-3.5 sm:p-4 rounded-2xl border transition-all cursor-pointer space-y-2 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-extrabold text-xs sm:text-sm text-slate-900 flex items-center gap-1.5 truncate">
                                    <i :class="'fa-solid ' + (spot.icon || 'fa-utensils') + ' text-emerald-600'"></i>
                                    <span x-text="spot.body_part"></span>
                                </span>
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full shrink-0"
                                      :class="spot.part_category === 'kerajinan' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900'"
                                      x-text="spot.part_category"></span>
                            </div>
                            <p class="text-xs text-slate-600 line-clamp-2 mt-1 font-medium leading-relaxed" x-text="spot.utilization_details || spot.recommended_recipes"></p>
                        </div>
                        <div class="text-[10px] font-extrabold text-emerald-700 flex items-center gap-1 pt-2 border-t border-slate-200/60">
                            <span>Klik untuk lihat di diagram</span> <i class="fa-solid fa-chevron-right text-[8px]"></i>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function anatomyDetailApp() {
        return {
            type: '{{ $type }}',
            allHotspots: @json($hotspots),
            activeFilter: 'all',
            activeSpot: null,
            devMode: false,

            init() {
                if (this.allHotspots.length > 0) {
                    this.activeSpot = this.allHotspots[0];
                }
            },

            get filteredHotspots() {
                if (this.activeFilter === 'all') {
                    return this.allHotspots;
                }
                return this.allHotspots.filter(spot => spot.part_category === this.activeFilter);
            },

            selectSpot(spot) {
                this.activeSpot = spot;
            },

            onCanvasClick(event) {
                if (!this.devMode || !this.activeSpot) return;

                const rect = event.currentTarget.getBoundingClientRect();
                const xPct = Math.round(((event.clientX - rect.left) / rect.width) * 100);
                const yPct = Math.round(((event.clientY - rect.top) / rect.height) * 100);

                this.activeSpot.pos_x = xPct;
                this.activeSpot.pos_y = yPct;
            },

            nudgePin(dx, dy) {
                if (!this.activeSpot) return;
                this.activeSpot.pos_x = Math.max(0, Math.min(100, this.activeSpot.pos_x + dx));
                this.activeSpot.pos_y = Math.max(0, Math.min(100, this.activeSpot.pos_y + dy));
            },

            getLabelPositionClass(spot) {
                if (this.type === 'kambing') {
                    if (spot.body_part.includes('Tanduk') || spot.body_part.includes('Punggung') || spot.body_part.includes('Kuku')) {
                        return 'bottom-8 sm:bottom-9 left-1/2 -translate-x-1/2';
                    }
                    if (spot.body_part.includes('Kepala')) {
                        return 'right-8 sm:right-9 top-1/2 -translate-y-1/2';
                    }
                    if (spot.body_part.includes('Mata')) {
                        return 'left-8 sm:left-9 top-1/2 -translate-y-1/2';
                    }
                } else {
                    if (spot.pos_y > 80) {
                        return 'bottom-8 sm:bottom-9 left-1/2 -translate-x-1/2';
                    }
                }
                return 'top-8 sm:top-9 left-1/2 -translate-x-1/2';
            }
        }
    }
</script>
@endpush
