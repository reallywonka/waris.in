<x-app-layout>
    <div class="space-y-10 sm:space-y-12">
        
        <!-- 1. Header Sapaan Mahasiswa (Jika Login) -->
        @auth
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-gray-100 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3.5">
                    <img class="w-12 h-12 rounded-full object-cover border border-emerald-800/20 shrink-0" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=065f46&color=ffffff' }}" 
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-base sm:text-lg font-black text-gray-900">
                                Halo, {{ Auth::user()->name }}
                            </h2>
                            <span class="inline-flex items-center space-x-1 text-[11px] font-bold bg-emerald-50 text-emerald-800 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                <span>Mahasiswa Aktif</span>
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5 flex items-center space-x-1.5">
                            <x-icon name="graduation-cap" class="w-3.5 h-3.5 text-emerald-800" />
                            <span>{{ Auth::user()->study_program ?? Auth::user()->faculty ?? 'Program Studi' }} &bull; Semester {{ Auth::user()->semester ?? '1' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Ringkasan Statistik & Tombol Pasang Cepat -->
                <div class="flex items-center space-x-2.5">
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl px-4 py-2 flex items-center space-x-2.5">
                        <x-icon name="package" class="w-4 h-4 text-emerald-800" />
                        <div>
                            <span class="block text-xs font-bold text-gray-800">{{ $userSharedCount }} Barang Terdaftar</span>
                        </div>
                    </div>
                    <a href="{{ route('items.create') }}" 
                       class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-bold text-xs rounded-full shadow-2xs transition-colors shrink-0 flex items-center space-x-1.5 cursor-pointer">
                        <x-icon name="plus" class="w-4 h-4" />
                        <span>Pasang Barang</span>
                    </a>
                </div>
            </div>

            <!-- Section Barang Milik Kamu (Jika Ada) -->
            @if ($myItems->count() > 0)
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-2xs space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-sm sm:text-base font-black text-gray-900 tracking-tight">
                                Barang yang Sedang Kamu Tawarkan / Jual
                            </h3>
                            <p class="text-xs text-gray-500">
                                Pantau ketersediaan dan respon peminat terhadap barang kuliahmu.
                            </p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('claims.incoming') }}" 
                               class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200/80 hover:bg-amber-100 transition-colors">
                                <x-icon name="inbox" class="w-3.5 h-3.5 text-amber-700" />
                                <span>Pengajuan Masuk ({{ $myPendingClaimsCount }})</span>
                            </a>
                            <a href="{{ route('items.my') }}" 
                                class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-full text-xs font-bold text-emerald-800 hover:bg-emerald-50 transition-colors">
                                <span>Lihat Semua</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($myItems as $myItem)
                            @php
                                $pendingClaims = $myItem->claims->where('status', 'pending')->count();
                            @endphp
                            <div class="bg-[#fbfbfb] hover:bg-white rounded-2xl p-3 border border-gray-100 hover:border-emerald-300 transition-all flex flex-col justify-between group">
                                <div class="space-y-2.5">
                                    <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-white border border-gray-100 p-2 flex items-center justify-center">
                                        <img src="{{ $myItem->primary_image_url }}" 
                                             alt="{{ $myItem->title }}"
                                             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';">
                                        
                                        <!-- Badge Status -->
                                        <div class="absolute top-2 left-2">
                                            @if ($myItem->status === 'available')
                                                <span class="inline-flex items-center space-x-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-800 text-white shadow-2xs">
                                                    <span class="w-1 h-1 rounded-full bg-emerald-300"></span>
                                                    <span>Tersedia</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center space-x-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-800 text-white shadow-2xs">
                                                    <x-icon name="lock" class="w-2.5 h-2.5 text-gray-300" />
                                                    <span>Terkunci</span>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Badge Mode Transaksi -->
                                        <div class="absolute bottom-2 right-2">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full shadow-2xs {{ $myItem->mode === 'harga_pas' ? 'bg-amber-100 text-amber-900 border border-amber-200' : ($myItem->mode === 'barter' ? 'bg-teal-100 text-teal-900 border border-teal-200' : 'bg-emerald-100 text-emerald-900 border border-emerald-200') }}">
                                                {{ $myItem->formatted_price }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('items.show', $myItem) }}" class="text-xs font-bold text-gray-900 line-clamp-1 hover:text-emerald-800 transition-colors">
                                            {{ $myItem->title }}
                                        </a>
                                        <div class="flex items-center justify-between text-[11px] text-gray-500 mt-1">
                                            <span>{{ $myItem->category }}</span>
                                            <span>{{ $myItem->condition }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-gray-100 flex items-center justify-between gap-2 text-xs">
                                    @if ($pendingClaims > 0)
                                        <a href="{{ route('claims.incoming', ['item_id' => $myItem->id]) }}" 
                                           class="inline-flex items-center space-x-1 font-bold text-amber-900 bg-amber-100/90 hover:bg-amber-200 px-2.5 py-0.5 rounded-full transition-colors text-[11px]">
                                            <x-icon name="users" class="w-3 h-3 text-amber-700" />
                                            <span>{{ $pendingClaims }} Peminat</span>
                                        </a>
                                    @else
                                        <span class="text-[11px] text-gray-400">
                                            {{ $myItem->claims->count() > 0 ? $myItem->claims->count() . ' Riwayat' : 'Belum ada peminat' }}
                                        </span>
                                    @endif

                                    <a href="{{ route('items.show', $myItem) }}" 
                                       class="font-bold text-emerald-800 hover:text-emerald-950 transition-colors text-xs">
                                        Detail &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        <!-- 2. Hero Section: Clean Showcase ala Shopee Reference -->
        <div class="bg-[#f6f5f2] rounded-3xl p-6 sm:p-12 lg:p-16 border border-gray-200/80 overflow-hidden text-center relative shadow-2xs">
            
            <div class="max-w-3xl mx-auto space-y-4 sm:space-y-6 relative z-10">
                <!-- Badge Tagline -->
                <div class="inline-flex items-center space-x-1.5 text-xs font-bold text-emerald-900 bg-white/90 border border-gray-200 px-3.5 py-1 rounded-full shadow-2xs">
                    <x-icon name="repeat" class="w-3.5 h-3.5 text-emerald-700" />
                    <span>Platform Pertukaran & Hibah Kampus</span>
                </div>

                <!-- Big Bold Headline (Typography Tegas ala Shopee) -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-[1.1]">
                    Oper barang kuliah yang sudah beres kamu pakai.
                </h1>

                <!-- Subtitle Deskripsi Asli -->
                <p class="text-xs sm:text-base text-gray-600 max-w-xl mx-auto leading-relaxed">
                    Tempat mahasiswa saling menghibahkan, barter, atau jual beli barang kuliah ramah kantong sesama rekan kampus. Tanpa perantara, langsung serah terima di kampus.
                </p>

                <!-- Dual CTA Action (Sesuai Gaya Shopee Reference: Solid Pill + Chevron Link) -->
                <div class="pt-2 flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                    <a href="{{ route('items.index') }}" 
                       class="px-7 py-3 rounded-full bg-emerald-800 hover:bg-emerald-900 active:bg-emerald-950 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors flex items-center space-x-2 cursor-pointer">
                        <span>Jelajahi Katalog Lengkap</span>
                        <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                    </a>
                    <a href="{{ route('items.create') }}" 
                       class="inline-flex items-center space-x-1.5 text-xs sm:text-sm font-bold text-emerald-800 hover:text-emerald-950 transition-colors cursor-pointer group">
                        <span>Pasang Barang Sekarang</span>
                        <x-icon name="chevron-right" class="w-4 h-4 text-emerald-700 group-hover:translate-x-0.5 transition-transform" />
                    </a>
                </div>

                <!-- Keyword Populer -->
                <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-gray-500 pt-2">
                    <span class="font-bold text-gray-700">Sering dicari:</span>
                    <a href="{{ route('items.index', ['search' => 'Kalkulus']) }}" class="text-emerald-800 hover:underline">Buku Kalkulus</a>
                    <span>&bull;</span>
                    <a href="{{ route('items.index', ['search' => 'Jas Lab']) }}" class="text-emerald-800 hover:underline">Jas Lab</a>
                    <span>&bull;</span>
                    <a href="{{ route('items.index', ['search' => 'Casio']) }}" class="text-emerald-800 hover:underline">Kalkulator fx-991EX</a>
                    <span>&bull;</span>
                    <a href="{{ route('items.index', ['search' => 'Almamater']) }}" class="text-emerald-800 hover:underline">Jaket Almamater</a>
                </div>
            </div>

            <!-- Hero Visual Showcase Barisan Barang Kuliah (Tabletop Product Arrangement ala Referensi Shopee) -->
            <div class="mt-8 sm:mt-12 pt-8 border-t border-gray-300/60 max-w-4xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Showcase Item 1: Buku & Diktat -->
                    <div class="bg-white/95 rounded-2xl p-4 border border-gray-200/90 shadow-2xs hover:shadow-xs transition-all flex flex-col items-center text-center space-y-2 group">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0 border border-emerald-100 group-hover:scale-105 transition-transform">
                            <x-icon name="book" class="w-6 h-6 text-emerald-800" />
                        </div>
                        <div>
                            <span class="block text-xs font-black text-gray-900 group-hover:text-emerald-800 transition-colors">Buku & Diktat</span>
                            <span class="text-[10px] text-gray-500">Materi semester kuliah</span>
                        </div>
                    </div>

                    <!-- Showcase Item 2: Gadget Belajar -->
                    <div class="bg-white/95 rounded-2xl p-4 border border-gray-200/90 shadow-2xs hover:shadow-xs transition-all flex flex-col items-center text-center space-y-2 group">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center shrink-0 border border-amber-100 group-hover:scale-105 transition-transform">
                            <x-icon name="cpu" class="w-6 h-6 text-amber-800" />
                        </div>
                        <div>
                            <span class="block text-xs font-black text-gray-900 group-hover:text-amber-800 transition-colors">Gadget Belajar</span>
                            <span class="text-[10px] text-gray-500">Kalkulator & modul lab</span>
                        </div>
                    </div>

                    <!-- Showcase Item 3: Jas Lab & Medis -->
                    <div class="bg-white/95 rounded-2xl p-4 border border-gray-200/90 shadow-2xs hover:shadow-xs transition-all flex flex-col items-center text-center space-y-2 group">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center shrink-0 border border-teal-100 group-hover:scale-105 transition-transform">
                            <x-icon name="shield" class="w-6 h-6 text-teal-800" />
                        </div>
                        <div>
                            <span class="block text-xs font-black text-gray-900 group-hover:text-teal-800 transition-colors">Jas Lab & Medis</span>
                            <span class="text-[10px] text-gray-500">Praktikum kampus</span>
                        </div>
                    </div>

                    <!-- Showcase Item 4: Perabot Kos -->
                    <div class="bg-white/95 rounded-2xl p-4 border border-gray-200/90 shadow-2xs hover:shadow-xs transition-all flex flex-col items-center text-center space-y-2 group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-800 flex items-center justify-center shrink-0 border border-blue-100 group-hover:scale-105 transition-transform">
                            <x-icon name="home" class="w-6 h-6 text-blue-800" />
                        </div>
                        <div>
                            <span class="block text-xs font-black text-gray-900 group-hover:text-blue-800 transition-colors">Perabot Kos</span>
                            <span class="text-[10px] text-gray-500">Meja belajar & lemari</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. Horizontal Quick Feature Strip (Gaya Unified 4 Icon Bar di Referensi Shopee) -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-2xs divide-y sm:divide-y-0 sm:divide-x divide-gray-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 overflow-hidden">
            <!-- Feature 1: Gratis -->
            <a href="{{ route('items.index', ['mode' => 'gratis']) }}" 
               class="p-4 sm:p-5 flex items-center space-x-3.5 hover:bg-emerald-50/40 transition-colors group">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0 border border-emerald-100 group-hover:scale-105 transition-transform">
                    <x-icon name="gift" class="w-5 h-5 text-emerald-800" />
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-900 block group-hover:text-emerald-900">Gratis (Hibah)</span>
                    <p class="text-[11px] text-gray-500 mt-0.5">Hibahkan untuk rekan tanpa biaya.</p>
                </div>
            </a>

            <!-- Feature 2: Harga Pas -->
            <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" 
               class="p-4 sm:p-5 flex items-center space-x-3.5 hover:bg-amber-50/40 transition-colors group">
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100 group-hover:scale-105 transition-transform">
                    <x-icon name="tag" class="w-5 h-5 text-amber-700" />
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-900 block group-hover:text-amber-900">Harga Pas Mahasiswa</span>
                    <p class="text-[11px] text-gray-500 mt-0.5">Jual murah ramah kantong.</p>
                </div>
            </a>

            <!-- Feature 3: Barter Barang -->
            <a href="{{ route('items.index', ['mode' => 'barter']) }}" 
               class="p-4 sm:p-5 flex items-center space-x-3.5 hover:bg-teal-50/40 transition-colors group">
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center shrink-0 border border-teal-100 group-hover:scale-105 transition-transform">
                    <x-icon name="repeat" class="w-5 h-5 text-teal-800" />
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-900 block group-hover:text-teal-900">Barter Barang</span>
                    <p class="text-[11px] text-gray-500 mt-0.5">Tukar dengan buku/alat matkul lain.</p>
                </div>
            </a>

            <!-- Feature 4: Serah Terima Kampus -->
            <a href="{{ route('items.index') }}" 
               class="p-4 sm:p-5 flex items-center space-x-3.5 hover:bg-slate-50 transition-colors group">
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center shrink-0 border border-slate-200 group-hover:scale-105 transition-transform">
                    <x-icon name="map-pin" class="w-5 h-5 text-slate-700" />
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-900 block group-hover:text-gray-900">Serah Terima Kampus</span>
                    <p class="text-[11px] text-gray-500 mt-0.5">Tatap muka langsung, tanpa ongkir.</p>
                </div>
            </a>
        </div>

        <!-- 4. Section Kategori Barang Kuliah ("Explore your everyday." style) -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                        Kategori Barang Kuliah
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Temukan perlengkapan sesuai bidang dan kebutuhan studimu.</p>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs sm:text-sm font-bold text-emerald-800 hover:text-emerald-950 flex items-center space-x-1 group">
                    <span>Semua Kategori</span>
                    <x-icon name="chevron-right" class="w-4 h-4 text-emerald-700 group-hover:translate-x-0.5 transition-transform" />
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
                @foreach ($categories as $cat)
                    <a href="{{ route('items.index', ['category' => $cat]) }}" 
                       class="flex flex-col items-center text-center space-y-2.5 group cursor-pointer">
                        <div class="w-full aspect-square max-w-[130px] rounded-2xl bg-[#f6f5f2] border border-gray-200/70 group-hover:border-emerald-300 group-hover:bg-emerald-50/50 p-4 flex items-center justify-center transition-all duration-200 shadow-2xs group-hover:shadow-xs">
                            <div class="w-12 h-12 rounded-xl bg-white text-emerald-800 flex items-center justify-center shadow-2xs group-hover:scale-110 transition-transform duration-200">
                                @if (str_contains($cat, 'Elektronik') || str_contains($cat, 'Gadget'))
                                    <x-icon name="cpu" class="w-6 h-6 text-emerald-800" />
                                @elseif (str_contains($cat, 'Buku') || str_contains($cat, 'Modul') || str_contains($cat, 'Diktat'))
                                    <x-icon name="book" class="w-6 h-6 text-emerald-800" />
                                @elseif (str_contains($cat, 'Praktikum') || str_contains($cat, 'Lab') || str_contains($cat, 'Medis'))
                                    <x-icon name="shield" class="w-6 h-6 text-emerald-800" />
                                @elseif (str_contains($cat, 'Fashion') || str_contains($cat, 'Pakaian') || str_contains($cat, 'Jaket'))
                                    <x-icon name="user" class="w-6 h-6 text-emerald-800" />
                                @elseif (str_contains($cat, 'Perlengkapan'))
                                    <x-icon name="package" class="w-6 h-6 text-emerald-800" />
                                @else
                                    <x-icon name="tag" class="w-6 h-6 text-emerald-800" />
                                @endif
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-emerald-800 transition-colors leading-snug">
                            {{ $cat }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 5. Section Listing Terbaru dari Rekan Kampus ("Daily Discover" style) -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                        Listing Terbaru dari Rekan Kampus
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Barang-barang perkuliahan yang siap diajukan hari ini.</p>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs sm:text-sm font-bold text-emerald-800 hover:text-emerald-950 flex items-center space-x-1 group">
                    <span>Buka Katalog Lengkap</span>
                    <x-icon name="chevron-right" class="w-4 h-4 text-emerald-700 group-hover:translate-x-0.5 transition-transform" />
                </a>
            </div>

            <!-- Grid Kartu Barang (Daily Discover Layout) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                @forelse ($recentItems as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300 space-y-2">
                        <x-icon name="package" class="w-8 h-8 text-gray-400 mx-auto" />
                        <p class="text-sm font-bold text-gray-700">Belum ada barang yang dipasang saat ini.</p>
                        <p class="text-xs text-gray-400">Jadilah mahasiswa pertama yang mengoper barang kuliah di sini!</p>
                        <div class="pt-2">
                            <a href="{{ route('items.create') }}" class="inline-flex items-center space-x-1.5 px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-full text-xs font-bold shadow-xs">
                                <x-icon name="plus" class="w-4 h-4" />
                                <span>Pasang Barang Sekarang</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 6. Section Banner: Gerakan Kampus Sirkular -->
        <div class="bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 sm:p-10 border border-emerald-800 flex flex-col sm:flex-row sm:items-center justify-between gap-6 shadow-xs">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-800 text-emerald-200 text-[11px] font-bold uppercase tracking-wide border border-emerald-700">
                    <x-icon name="repeat" class="w-3.5 h-3.5 text-emerald-300" />
                    <span>Gerakan Kampus Sirkular</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-white leading-snug">
                    Warisan barang berharga antar civitas akademika.
                </h3>
                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                    Dari buku kuliah, alat laboratorium, sampai perlengkapan kos. Lebih hemat, kurangi limbah, pererat silaturahmi.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('items.index') }}" 
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-white text-emerald-900 hover:bg-emerald-50 font-bold text-xs sm:text-sm rounded-full shadow-2xs transition-colors cursor-pointer">
                    <span>Jelajahi Katalog Lengkap</span>
                    <x-icon name="arrow-right" class="w-4 h-4 text-emerald-900" />
                </a>
            </div>
        </div>

    </div>
</x-app-layout>