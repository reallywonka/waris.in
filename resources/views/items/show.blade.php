<x-app-layout>
    @php
        $isOwner = auth()->check() && auth()->id() === $item->user_id;
        $isAvailable = $item->status === 'available';
        
        // Kumpulkan seluruh foto barang (primary + foto pendukung)
        $allImages = $item->images->count() > 0 
            ? $item->images->map(fn($img) => $img->url)->values()->all()
            : [$item->primary_image_url];
    @endphp

    <div x-data="{ 
            activeImageIndex: 0, 
            images: {{ json_encode($allImages) }},
            copied: false,
            copyUrl() {
                navigator.clipboard.writeText(window.location.href);
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            }
         }" 
         class="space-y-10 pb-20 lg:pb-8">

        <!-- 1. Top Bar: Breadcrumbs & Kembali ke Katalog -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-gray-200">
            <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 overflow-x-auto whitespace-nowrap">
                <a href="{{ route('items.index') }}" class="inline-flex items-center space-x-1 text-emerald-800 hover:text-emerald-950 font-bold transition-colors">
                    <x-icon name="arrow-left" class="w-3.5 h-3.5" />
                    <span>Kembali ke Katalog</span>
                </a>
                <span class="text-gray-300">/</span>
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                <span class="text-gray-300">/</span>
                <a href="{{ route('items.index', ['category' => $item->category]) }}" class="hover:text-emerald-800 transition-colors font-semibold text-emerald-800">
                    {{ $item->category }}
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-800 font-bold truncate max-w-xs" title="{{ $item->title }}">
                    {{ $item->title }}
                </span>
            </nav>

            <!-- Listing ID & Tombol Salin Tautan Solid -->
            <div class="flex items-center space-x-3 text-xs text-gray-500 shrink-0">
                <span class="font-mono text-[11px] bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg border border-gray-200">
                    #WARIS-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                </span>
                <button @click="copyUrl()" 
                        class="inline-flex items-center space-x-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-950 transition-colors focus:outline-none">
                    <x-icon name="link" class="w-3.5 h-3.5" />
                    <span x-show="!copied">Salin Tautan</span>
                    <span x-show="copied" class="text-emerald-700 font-bold">✓ Tautan Disalin!</span>
                </button>
            </div>
        </div>

        <!-- 2. Grid Utama Produk: Galeri Kiri (Sticky) + Detail Kanan -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- Sisi Kiri (Col 12 -> Col 6): Galeri Foto Interaktif (Sticky on Desktop) -->
            <div class="lg:col-span-6 lg:sticky lg:top-28 space-y-4">
                
                <!-- Frame Gambar Utama Solid -->
                <div class="relative bg-white rounded-3xl overflow-hidden border border-gray-200 shadow-2xs aspect-4/3 flex items-center justify-center group">
                    <img :src="images[activeImageIndex]" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover transition-all duration-300 group-hover:scale-[1.02] {{ !$isAvailable ? 'grayscale-[35%]' : '' }}">

                    <!-- Overlay Mode Badge (Kiri Atas) -->
                    <div class="absolute top-4 left-4 flex flex-wrap gap-2 items-center">
                        @if ($item->mode === 'harga_pas')
                            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-2xl text-xs font-black bg-amber-500 text-white shadow-2xs">
                                <x-icon name="tag" class="w-3.5 h-3.5 text-white" />
                                <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </span>
                        @elseif ($item->mode === 'gratis')
                            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-2xl text-xs font-black bg-emerald-700 text-white shadow-2xs">
                                <x-icon name="gift" class="w-3.5 h-3.5 text-white" />
                                <span>Gratis (Hibah)</span>
                            </span>
                        @elseif ($item->mode === 'barter')
                            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-2xl text-xs font-black bg-teal-700 text-white shadow-2xs">
                                <x-icon name="repeat" class="w-3.5 h-3.5 text-white" />
                                <span>Mode Barter</span>
                            </span>
                        @endif

                        @if ($isOwner)
                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-gray-900/90 text-emerald-300 border border-emerald-400/30">
                                <x-icon name="user" class="w-3 h-3" />
                                <span>Barang Anda Sendiri</span>
                            </span>
                        @endif
                    </div>

                    <!-- Overlay Ketersediaan (Kanan Atas) -->
                    <div class="absolute top-4 right-4">
                        @if ($isAvailable)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-emerald-800 shadow-2xs border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 me-2 animate-pulse"></span>
                                Tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-900/90 text-gray-200 border border-white/20">
                                <x-icon name="lock" class="w-3 h-3 text-gray-300" />
                                <span>Terkunci</span>
                            </span>
                        @endif
                    </div>

                    <!-- Tombol Navigasi Prev/Next Foto (Jika lebih dari 1 foto) -->
                    <template x-if="images.length > 1">
                        <div>
                            <button @click="activeImageIndex = (activeImageIndex === 0) ? images.length - 1 : activeImageIndex - 1"
                                    aria-label="Foto Sebelumnya"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center transition-colors focus:outline-none">
                                <x-icon name="arrow-left" class="w-4 h-4 text-white" />
                            </button>
                            <button @click="activeImageIndex = (activeImageIndex === images.length - 1) ? 0 : activeImageIndex + 1"
                                    aria-label="Foto Berikutnya"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 text-white flex items-center justify-center transition-colors focus:outline-none">
                                <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Thumbnail Reel Solid di Bawah Gambar Utama -->
                <template x-if="images.length > 1">
                    <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-none">
                        <template x-for="(img, idx) in images" :key="idx">
                            <button @click="activeImageIndex = idx"
                                    class="relative w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all shrink-0 focus:outline-none"
                                    :class="activeImageIndex === idx ? 'border-emerald-700 ring-2 ring-emerald-600/30 scale-105' : 'border-gray-200 hover:border-gray-300 opacity-70 hover:opacity-100'">
                                <img :src="img" alt="Thumbnail" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Sisi Kanan (Col 12 -> Col 6): Rincian Spesifikasi, Profil & Aksi Transaksi -->
            <div class="lg:col-span-6 space-y-6">
                
                <!-- 1. Header Judul & Tag Kategori -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <x-icon name="folder" class="w-3.5 h-3.5 text-emerald-700" />
                            <span>{{ $item->category }}</span>
                        </span>
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                            <x-icon name="sparkles" class="w-3.5 h-3.5 text-gray-500" />
                            <span>{{ $item->condition }}</span>
                        </span>
                        <span class="text-xs text-gray-400 ms-auto flex items-center space-x-1">
                            <x-icon name="clock" class="w-3.5 h-3.5 text-gray-400" />
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-snug">
                        {{ $item->title }}
                    </h1>

                    <!-- Highlight Mode Transaksi (Solid Card) -->
                    <div class="p-4 sm:p-5 rounded-2xl {{ $item->mode === 'harga_pas' ? 'bg-amber-50 border border-amber-200' : ($item->mode === 'barter' ? 'bg-teal-50 border border-teal-200' : 'bg-emerald-50 border border-emerald-200') }}">
                        @if ($item->mode === 'harga_pas')
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] font-bold text-amber-800 uppercase tracking-wider block">Harga Pas Mahasiswa</span>
                                    <span class="text-3xl font-black text-amber-950 mt-1 block">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-800 border border-amber-200">
                                    <x-icon name="tag" class="w-6 h-6 text-amber-800" />
                                </div>
                            </div>
                            <p class="text-xs text-amber-900 mt-2 leading-relaxed font-medium">
                                Transaksi dibayar tunai atau transfer langsung saat ketemuan (COD di kampus). Tanpa potongan komisi platform.
                            </p>
                        @elseif ($item->mode === 'barter')
                            <div class="space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-teal-800 uppercase tracking-wider block">Mode Barter / Tukar Barang</span>
                                    <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-800 border border-teal-200">
                                        <x-icon name="repeat" class="w-5 h-5 text-teal-800" />
                                    </div>
                                </div>
                                <div class="bg-white p-3.5 rounded-xl border border-teal-200">
                                    <span class="text-[11px] font-bold text-teal-900 block">Pemilik mencari barang penukar:</span>
                                    <p class="text-xs font-semibold text-gray-800 mt-1 italic">
                                        "{{ $item->barter_request ?? 'Terbuka tawaran barang kuliah sepadan' }}"
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider block">Pahala & Hibah Bersih</span>
                                    <span class="text-2xl sm:text-3xl font-black text-emerald-950 mt-1 block">
                                        Rp 0 (100% Gratis)
                                    </span>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-800 border border-emerald-200">
                                    <x-icon name="gift" class="w-6 h-6 text-emerald-800" />
                                </div>
                            </div>
                            <p class="text-xs text-emerald-900 mt-2 leading-relaxed font-medium">
                                Silakan klaim bagi yang membutuhkan untuk perlengkapan kuliah. Dijaga amanahnya ya!
                            </p>
                        @endif
                    </div>
                </div>

                <!-- 2. Kartu Profil Pemilik Barang (Sivitas Kampus Terverifikasi) -->
                <div class="bg-white rounded-3xl p-5 border border-gray-200 shadow-2xs flex items-center justify-between gap-4">
                    <div class="flex items-center space-x-3.5 truncate">
                        <img src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=144d37&color=ffffff' }}" 
                             alt="{{ $item->user->name }}" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-emerald-700/20 shrink-0">
                        <div class="truncate">
                            <div class="flex items-center space-x-1.5">
                                <span class="font-bold text-gray-900 text-sm truncate">{{ $item->user->name }}</span>
                                <x-icon name="user-check" class="w-4 h-4 text-emerald-700 shrink-0" />
                            </div>
                            <span class="text-xs text-gray-500 block truncate mt-0.5">
                                {{ $item->user->faculty ?? 'Mahasiswa Kampus' }} &bull; Angkatan {{ $item->user->batch ?? 'Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right shrink-0">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Jejak Kebaikan</span>
                        <span class="text-xs font-black text-emerald-800 block mt-0.5">
                            {{ $item->user->items()->count() }} Terpasang
                        </span>
                    </div>
                </div>

                <!-- 3. Rencana Ketemuan (COD Kampus) & Catatan Kondisi Fisik -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-2xs space-y-4">
                    
                    <!-- Lokasi & Waktu Serah Terima -->
                    <div class="space-y-2">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">
                            Rencana Titik Ketemuan (COD Kampus):
                        </span>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-2xl border border-gray-200">
                                <div class="w-8 h-8 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                                    <x-icon name="map-pin" class="w-4 h-4 text-emerald-800" />
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold">Titik Lokasi Kampus</span>
                                    <span class="text-gray-900 font-bold truncate block">{{ $item->meetup_location ?? 'Sekitar Kampus Utama' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-2xl border border-gray-200">
                                <div class="w-8 h-8 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                                    <x-icon name="clock" class="w-4 h-4 text-emerald-800" />
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold">Waktu Serah Terima</span>
                                    <span class="text-gray-900 font-bold truncate block">{{ $item->time_handover ?? 'Fleksibel sepulang kuliah' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Kejujuran Kondisi (Jika Ada) -->
                    @if ($item->condition_note)
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 space-y-1">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">
                                Catatan Kejujuran Kondisi:
                            </span>
                            <p class="text-xs text-gray-700 leading-relaxed italic">
                                "{{ $item->condition_note }}"
                            </p>
                        </div>
                    @endif

                    <!-- Deskripsi Lengkap -->
                    <div class="pt-2">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">
                            Deskripsi Barang:
                        </span>
                        <div class="text-xs sm:text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $item->description }}
                        </div>
                    </div>
                </div>

                <!-- 4. Tombol Aksi Kontekstual Pintar (Solid Buttons) -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-2xs">
                    @if ($isOwner)
                        <!-- Skenario 1: User adalah Pemilik Barang -->
                        <div class="space-y-3">
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 p-3.5 rounded-2xl text-xs flex items-center justify-between">
                                <div>
                                    <span class="font-bold block">Status Listing Barang Anda:</span>
                                    <span class="text-[11px]">{{ $item->claims->count() }} Mahasiswa Mengajukan Klaim / Barter</span>
                                </div>
                                <x-icon name="inbox" class="w-6 h-6 text-emerald-800" />
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-2.5">
                                <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" 
                                   class="w-full sm:flex-1 py-3 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl transition-colors text-center">
                                    Lihat Pengajuan Masuk ({{ $item->claims->count() }})
                                </a>
                                <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                                   class="w-full sm:w-auto py-3 px-5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs rounded-xl transition-colors text-center">
                                    Kelola Barang Saya
                                </a>
                            </div>
                        </div>

                    @elseif (!$isAvailable)
                        <!-- Skenario 2: Barang Sudah Terkunci / Diambil -->
                        <div class="bg-gray-50 border border-gray-200 p-5 rounded-2xl text-center space-y-2">
                            <x-icon name="lock" class="w-6 h-6 text-gray-400 mx-auto" />
                            <span class="text-sm font-bold text-gray-900 block">Barang Sudah Terkunci</span>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto leading-relaxed">
                                Barang ini telah disetujui untuk mahasiswa lain. Coba cari barang serupa di katalog kampus ya!
                            </p>
                        </div>

                    @elseif ($userClaim)
                        <!-- Skenario 3: User Sudah Pernah Mengajukan Klaim -->
                        <div class="p-5 rounded-2xl border text-center space-y-2 {{ $userClaim->status === 'approved' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : ($userClaim->status === 'rejected' ? 'bg-rose-50 border-rose-200 text-rose-900' : 'bg-amber-50 border-amber-200 text-amber-900') }}">
                            <div class="mx-auto w-8 h-8 rounded-full flex items-center justify-center {{ $userClaim->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($userClaim->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                <x-icon name="{{ $userClaim->status === 'approved' ? 'check' : ($userClaim->status === 'rejected' ? 'lock' : 'clock') }}" class="w-4 h-4" />
                            </div>
                            <span class="text-sm font-bold block">
                                {{ $userClaim->status === 'approved' ? 'Pengajuan Anda Telah Disetujui Pemilik!' : ($userClaim->status === 'rejected' ? 'Pengajuan Anda Belum Terpilih' : 'Pengajuan Anda Sedang Ditinjau') }}
                            </span>
                            <p class="text-xs opacity-90 max-w-sm mx-auto leading-relaxed">
                                @if ($userClaim->status === 'approved')
                                    Silakan hubungi pemilik barang via kontak yang terbuka di menu "Pengajuan Saya".
                                @elseif ($userClaim->status === 'pending')
                                    Tunggu persetujuan dari pemilik barang. Kamu akan segera diberitahu begitu pemilik merespons.
                                @else
                                    Barang ini dialokasikan kepada mahasiswa lain yang lebih membutuhkan.
                                @endif
                            </p>
                            <div class="pt-1">
                                <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" class="inline-flex items-center text-xs font-bold underline">
                                    Buka Menu Pengajuan Saya &rarr;
                                </a>
                            </div>
                        </div>

                    @else
                        <!-- Skenario 4: Barang Tersedia & Siap Diklaim -->
                        @auth
                            <div class="space-y-2.5">
                                <button type="button"
                                        onclick="alert('Fitur Formulir Pengajuan Klaim / Barter siap dihubungkan pada Task 7!')"
                                        class="w-full py-4 px-6 bg-emerald-800 hover:bg-emerald-900 text-white font-black text-sm rounded-2xl shadow-2xs hover:shadow-xs transition-all flex items-center justify-center space-x-2">
                                    <span>{{ $item->mode === 'barter' ? 'Ajukan Tawaran Barter' : ($item->mode === 'gratis' ? 'Ajukan Klaim Gratis' : 'Ajukan Pembelian Harga Pas') }}</span>
                                    <x-icon name="arrow-right" class="w-4 h-4" />
                                </button>
                                <p class="text-[11px] text-gray-400 text-center flex items-center justify-center space-x-1">
                                    <x-icon name="shield" class="w-3.5 h-3.5 text-gray-400" />
                                    <span>Nomor kontak Anda aman dan hanya terbuka ke pemilik jika pengajuan disetujui.</span>
                                </p>
                            </div>
                        @else
                            <div class="bg-emerald-50 border border-emerald-200 p-5 rounded-2xl text-center space-y-2.5">
                                <span class="text-sm font-bold text-emerald-950 block">Tertarik dengan barang kuliah ini?</span>
                                <p class="text-xs text-emerald-800 leading-relaxed max-w-sm mx-auto font-medium">
                                    Silakan masuk dengan akun mahasiswa Anda untuk mengajukan klaim atau barter tanpa perantara.
                                </p>
                                <a href="{{ route('login') }}" 
                                   class="inline-block w-full py-3 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-2xs transition-colors">
                                    Masuk untuk Mengajukan
                                </a>
                            </div>
                        @endauth
                    @endif
                </div>

            </div>
        </div>

        <!-- 3. Rekomendasi Barang Terkait (Related Items) -->
        @if ($relatedItems->count() > 0)
            <div class="pt-10 border-t border-gray-200 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200">
                            ● Rekomendasi Kampus
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-1">
                            Barang Lain di Kategori {{ $item->category }}
                        </h2>
                    </div>
                    <a href="{{ route('items.index', ['category' => $item->category]) }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 transition-colors flex items-center space-x-1">
                        <span>Lihat Semua</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedItems as $related)
                        <x-item-card :item="$related" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4. Mobile Sticky Bottom Action Bar (Ergonomi Jempol Ponsel - antislop-layoutmobile) -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 p-3 bg-white border-t border-gray-200 z-40 shadow-lg flex items-center justify-between gap-3">
            <div>
                <span class="text-[10px] text-gray-400 block font-semibold">Mode Transaksi</span>
                <span class="text-xs font-black {{ $item->mode === 'harga_pas' ? 'text-amber-800' : ($item->mode === 'barter' ? 'text-teal-800' : 'text-emerald-800') }}">
                    {{ $item->formatted_price }}
                </span>
            </div>

            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-2xs">
                        Lihat Pengajuan ({{ $item->claims->count() }})
                    </a>
                @elseif (!$isAvailable)
                    <button disabled class="inline-flex items-center space-x-1 px-4 py-2.5 bg-gray-200 text-gray-400 font-bold text-xs rounded-xl cursor-not-allowed">
                        <x-icon name="lock" class="w-3.5 h-3.5" />
                        <span>Terkunci</span>
                    </button>
                @elseif ($userClaim)
                    <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-amber-500 text-white font-bold text-xs rounded-xl shadow-2xs">
                        Status Pengajuan
                    </a>
                @else
                    @auth
                        <button type="button" 
                                onclick="alert('Fitur Formulir Pengajuan Klaim / Barter siap dihubungkan pada Task 7!')"
                                class="inline-flex items-center space-x-1.5 px-5 py-2.5 bg-emerald-800 text-white font-black text-xs rounded-xl shadow-2xs">
                            <span>Ajukan {{ $item->mode === 'barter' ? 'Barter' : 'Klaim' }}</span>
                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                        </button>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-4 py-2.5 bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-2xs">
                            Masuk untuk Klaim
                        </a>
                    @endauth
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
