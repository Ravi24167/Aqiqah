@extends('layouts.app')

@section('title', 'Panel DKM Masjid - AqiqahKita')

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]" x-data="dkmAdminApp()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Info -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-emerald-800 via-emerald-700 to-amber-600 p-8 rounded-3xl text-white shadow-xl">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/20 border border-white/30 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    <i class="fa-solid fa-mosque text-amber-300"></i> DKM Admin Panel
                </div>
                <h1 class="text-3xl font-black font-heading">{{ Auth::user()->masjid_name }}</h1>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1">Penanggung Jawab: {{ Auth::user()->name }} | {{ Auth::user()->phone_number }}</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button @click="showAddAnimalModal = true" class="bg-amber-400 hover:bg-amber-300 text-slate-900 font-black text-xs md:text-sm px-5 py-3 rounded-2xl shadow-lg transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus text-base"></i> Tambah Hewan Ternak
                </button>
            </div>
        </div>

        <!-- Main Dashboard Navigation Tabs -->
        <div class="flex items-center gap-4 border-b border-slate-200 pb-2">
            <button @click="activeTab = 'chat'" 
                    :class="activeTab === 'chat' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                    class="font-black text-sm px-6 py-3 rounded-2xl transition-all flex items-center gap-2 relative">
                <i class="fa-solid fa-comments"></i> Inbox Chat Jamaah / Tamu
                <span x-show="totalUnread > 0" x-text="totalUnread" class="bg-amber-400 text-slate-900 text-[10px] font-black px-2 py-0.5 rounded-full"></span>
            </button>

            <button @click="activeTab = 'animals'" 
                    :class="activeTab === 'animals' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                    class="font-black text-sm px-6 py-3 rounded-2xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-paw"></i> Kelola Hewan Ternak ({{ count($animals) }})
            </button>
        </div>

        <!-- TAB 1: LIVE CHAT INBOX -->
        <div x-show="activeTab === 'chat'" class="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-white rounded-3xl p-6 shadow-sm border border-slate-200 min-h-[550px]">
            
            <!-- Left Column: Guest Conversation List -->
            <div class="lg:col-span-5 border-r border-slate-100 pr-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-black font-heading text-slate-900 text-base">Pesan Masuk Jamaah</h3>
                    <button @click="fetchConversations()" class="text-xs font-bold text-emerald-600 hover:underline">
                        <i class="fa-solid fa-arrows-rotate"></i> Refresh
                    </button>
                </div>

                <div class="space-y-2 overflow-y-auto max-h-[460px]">
                    <template x-for="conv in conversations" :key="conv.guest_token">
                        <div @click="selectConversation(conv.guest_token, conv.guest_name)" 
                             :class="selectedToken === conv.guest_token ? 'bg-emerald-50 border-emerald-300' : 'bg-slate-50 hover:bg-slate-100 border-transparent'"
                             class="p-4 rounded-2xl border transition-all cursor-pointer space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-user text-emerald-600"></i> <span x-text="conv.guest_name"></span>
                                </span>
                                <span x-show="conv.unread_count > 0" class="bg-amber-400 text-slate-900 text-[10px] font-black px-2 py-0.5 rounded-full" x-text="conv.unread_count + ' baru'"></span>
                            </div>
                            <p class="text-xs text-slate-500 line-clamp-1 font-medium" x-text="conv.last_message || 'Belum ada pesan'"></p>
                            <span class="text-[10px] text-slate-400 block text-right font-bold" x-text="conv.last_time"></span>
                        </div>
                    </template>

                    <template x-if="conversations.length === 0">
                        <div class="text-center py-16 text-slate-400 space-y-2">
                            <i class="fa-solid fa-inbox text-3xl text-emerald-300"></i>
                            <p class="text-xs font-bold text-slate-600">Belum ada chat dari penanya/jamaah.</p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right Column: Conversation Active Chat Window -->
            <div class="lg:col-span-7 flex flex-col justify-between h-full bg-slate-50 rounded-2xl p-4 border border-slate-200">
                <template x-if="selectedToken">
                    <div class="flex flex-col h-[480px]">
                        <!-- Chat Header -->
                        <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center justify-between mb-3 shadow-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="font-black text-sm text-slate-900" x-text="selectedGuestName"></span>
                            </div>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full">
                                Percakapan Langsung
                            </span>
                        </div>

                        <!-- Chat Messages List -->
                        <div class="flex-grow overflow-y-auto space-y-3 p-3 bg-white rounded-xl border border-slate-100 mb-3" id="dkmChatMessages">
                            <template x-for="msg in messages" :key="msg.id">
                                <div :class="msg.sender_type === 'dkm' ? 'flex justify-end' : 'flex justify-start'">
                                    <div :class="msg.sender_type === 'dkm' ? 'bg-emerald-600 text-white rounded-2xl rounded-tr-none' : 'bg-slate-100 text-slate-800 rounded-2xl rounded-tl-none'"
                                         class="max-w-[80%] p-3 text-xs space-y-1">
                                        <p x-text="msg.message" class="leading-relaxed font-medium"></p>
                                        <span :class="msg.sender_type === 'dkm' ? 'text-emerald-200' : 'text-slate-400'" class="text-[9px] block text-right font-bold" x-text="formatTime(msg.created_at)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Reply Box -->
                        <div class="flex gap-2">
                            <input type="text" x-model="replyText" @keyup.enter="sendReply()" placeholder="Ketik balasan untuk jamaah..." 
                                   class="flex-grow text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm">
                            <button @click="sendReply()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition-all flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Balas
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="!selectedToken">
                    <div class="flex flex-col items-center justify-center h-[480px] text-center text-slate-400 space-y-2">
                        <i class="fa-solid fa-comments text-4xl text-amber-400"></i>
                        <p class="text-sm font-bold text-slate-600">Pilih salah satu obrolan jamaah di sebelah kiri untuk membalas pertanyaan.</p>
                    </div>
                </template>
            </div>

        </div>

        <!-- TAB 2: ANIMAL INVENTORY -->
        <div x-show="activeTab === 'animals'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($animals as $animal)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">
                                    {{ strtoupper($animal->type) }}
                                </span>
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">
                                    {{ strtoupper($animal->category) }}
                                </span>
                            </div>

                            <img src="{{ asset($animal->image ?: 'images/kambing.jpg') }}" class="w-full h-40 object-cover rounded-2xl mb-3 border border-slate-100">

                            <h4 class="font-extrabold font-heading text-slate-900 text-lg line-clamp-1">{{ $animal->name }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $animal->description }}</p>

                            <div class="mt-3 bg-slate-50 p-3 rounded-xl text-xs font-bold text-slate-700 space-y-1">
                                <div>Harga: <span class="text-emerald-700 font-extrabold">{{ $animal->formatted_price }}</span></div>
                                <div>Berat: <span>{{ $animal->weight_kg }} kg</span></div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <form action="{{ route('dkm.animal.status', $animal->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold bg-slate-100 border border-slate-200 rounded-lg px-2 py-1">
                                    <option value="available" {{ $animal->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="reserved" {{ $animal->status === 'reserved' ? 'selected' : '' }}>Dipesan</option>
                                    <option value="sold" {{ $animal->status === 'sold' ? 'selected' : '' }}>Terjual</option>
                                </select>
                            </form>

                            <form action="{{ route('dkm.animal.delete', $animal->id) }}" method="POST" onsubmit="return confirm('Hapus hewan ini dari katalog?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold p-1">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- MODAL TAMBAH HEWAN -->
    <div x-show="showAddAnimalModal" x-transition class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative border border-emerald-100">
            <button @click="showAddAnimalModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-2xl font-black font-heading text-slate-900 mb-4">Tambah Hewan Ternak Baru</h3>

            <form action="{{ route('dkm.animal.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Nama Paket / Hewan</label>
                    <input type="text" name="name" required placeholder="Contoh: Kambing Aqiqah Jantan Grade A" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Jenis Hewan</label>
                        <select name="type" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="kambing">Kambing</option>
                            <option value="sapi">Sapi</option>
                            <option value="domba">Domba</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Kategori Penjualan</label>
                        <select name="category" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="aqiqah">Aqiqah</option>
                            <option value="qurban">Qurban Idul Adha</option>
                            <option value="harian">Harian / Syukuran</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="2800000" 
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Berat (kg)</label>
                        <input type="number" step="0.5" name="weight_kg" required placeholder="32" 
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Kelamin</label>
                        <select name="gender" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="Jantan">Jantan</option>
                            <option value="Betina">Betina</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-700 tracking-wider mb-1">Deskripsi & Keunggulan</label>
                    <textarea name="description" rows="3" placeholder="Syar'i, sehat, pakan teratur, siap dipotong kapan saja..." 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm py-3 rounded-xl shadow-md transition-all">
                    Simpan Hewan Ke Katalog
                </button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function dkmAdminApp() {
        return {
            activeTab: 'chat',
            showAddAnimalModal: false,
            conversations: [],
            selectedToken: null,
            selectedGuestName: '',
            messages: [],
            replyText: '',
            totalUnread: 0,
            pollInterval: null,

            init() {
                this.fetchConversations();
                this.pollInterval = setInterval(() => {
                    this.fetchConversations();
                    if (this.selectedToken) {
                        this.fetchGuestMessages(this.selectedToken);
                    }
                }, 4000);
            },

            fetchConversations() {
                fetch('/dkm/api/conversations')
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.conversations = data.conversations;
                            this.totalUnread = this.conversations.reduce((sum, item) => sum + item.unread_count, 0);
                        }
                    });
            },

            selectConversation(token, guestName) {
                this.selectedToken = token;
                this.selectedGuestName = guestName;
                this.fetchGuestMessages(token);
            },

            fetchGuestMessages(token) {
                fetch(`/dkm/api/messages/${token}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.messages = data.messages;
                            this.scrollToBottom();
                        }
                    });
            },

            sendReply() {
                if (!this.replyText.trim() || !this.selectedToken) return;

                const text = this.replyText;
                this.replyText = '';

                fetch('/dkm/api/reply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guest_token: this.selectedToken,
                        message: text
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.fetchConversations();
                        this.scrollToBottom();
                    }
                });
            },

            scrollToBottom() {
                setTimeout(() => {
                    const el = document.getElementById('dkmChatMessages');
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
</script>
@endpush
