<x-app-layout>
    <div class="space-y-10">
        
        <!-- 1. Header Sapaan Personal Mahasiswa (Jika Login) -->
        @auth
            <div class="bg-white rounded-3xl p-5 border border-gray-200/90 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3.5">
                    <img class="w-12 h-12 rounded-full object-cover border-2 border-emerald-700/20" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-base sm:text-lg font-black text-gray-900">
                                Hai, {{ Auth::user()->name }}!
                            </h2>
                            <span class="inline-flex items-center space-x-1 text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">
                                <x-icon name="check" class="w-2.5 h-2.5" />
                                <span>Mahasiswa Aktif</span>
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5 flex items-center space-x-1.5">
                            <x-icon name="graduation-cap" class="w-3.5 h-3.5 text-emerald-700" />
                            <span>{{ Auth::user()->study_program ?? Auth::user()->faculty ?? 'Program Studi' }} &bull; Semester {{ Auth::user()->semester ?? '1' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Badge Jejak Kebaikan & Tombol Pasang Cepat -->
                <div class="flex items-center space-x-2.5">
                    <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl px-4 py-2 flex items-center space-x-3">
                        <x-icon name="leaf" class="w-5 h-5 text-emerald-700" />
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-emerald-800 tracking-wider">Jejak Kebaikan</span>
                            <span class="text-xs font-black text-gray-900">{{ $userSharedCount }} Barang Disalurkan</span>
                        </div>
                    </div>
                    <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                       class="px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-2xl shadow-2xs transition-colors shrink-0 flex items-center space-x-1.5">
                        <x-icon name="plus" class="w-4 h-4" />
                        <span>Pasang Barang</span>
                    </a>
                </div>
            </div>

            <!-- Section Progres & Barang Milik Kamu (Task 6 & Tracking Kebaikan) -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-2xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                            <x-icon name="package" class="w-4 h-4 text-emerald-800" />
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-black text-gray-900 tracking-tight">
                                Barang yang Sedang Kamu Tawarkan / Jual
                            </h3>
                            <p class="text-[11px] text-gray-500">
                                Pantau ketersediaan dan minat mahasiswa lain terhadap barang kuliahmu.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('claims.incoming') }}" 
                           class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200 hover:bg-amber-100 transition-colors">
                            <x-icon name="inbox" class="w-3.5 h-3.5 text-amber-700" />
                            <span>Pengajuan Masuk ({{ $myPendingClaimsCount }})</span>
                        </a>
                        <a href="{{ route('items.my') }}" 
                           class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-800 hover:bg-emerald-50 transition-colors">
                            <span>Buka Semua Barang Saya</span>
                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                        </a>
                    </div>
                </div>

                @if ($myItems->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($myItems as $myItem)
                            @php
                                $pendingClaims = $myItem->claims->where('status', 'pending')->count();
                            @endphp
                            <div class="bg-gray-50/70 hover:bg-white rounded-2xl p-3.5 border border-gray-200 hover:border-emerald-300 transition-all flex flex-col justify-between group">
                                <div class="space-y-3">
                                    <div class="relative w-full aspect-4/3 rounded-xl overflow-hidden bg-gray-100 border border-gray-200/80">
                                        <img src="{{ $myItem->primary_image_url }}" 
                                             alt="{{ $myItem->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';">
                                        
                                        <!-- Badge Status -->
                                        <div class="absolute top-2 left-2">
                                            @if ($myItem->status === 'available')
                                                <span class="inline-flex items-center space-x-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-800 text-white shadow-2xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                                                    <span>Tersedia</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center space-x-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-gray-800 text-white shadow-2xs">
                                                    <x-icon name="lock" class="w-2.5 h-2.5" />
                                                    <span>Terkunci</span>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Badge Mode Transaksi -->
                                        <div class="absolute bottom-2 right-2">
                                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md shadow-2xs {{ $myItem->mode === 'harga_pas' ? 'bg-amber-100 text-amber-900 border border-amber-200' : ($myItem->mode === 'barter' ? 'bg-teal-100 text-teal-900 border border-teal-200' : 'bg-emerald-100 text-emerald-900 border border-emerald-200') }}">
                                                {{ $myItem->formatted_price }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('items.show', $myItem) }}" class="text-xs font-black text-gray-900 line-clamp-1 hover:text-emerald-800 transition-colors">
                                            {{ $myItem->title }}
                                        </a>
                                        <div class="flex items-center justify-between text-[11px] text-gray-500 mt-1">
                                            <span>{{ $myItem->category }}</span>
                                            <span>{{ $myItem->condition }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-gray-200/80 flex items-center justify-between gap-2">
                                    @if ($pendingClaims > 0)
                                        <a href="{{ route('claims.incoming', ['item_id' => $myItem->id]) }}" 
                                           class="inline-flex items-center space-x-1 text-[11px] font-bold text-amber-800 bg-amber-100/90 hover:bg-amber-200 px-2.5 py-1 rounded-lg transition-colors">
                                            <x-icon name="users" class="w-3 h-3 text-amber-700" />
                                            <span>{{ $pendingClaims }} Peminat Baru</span>
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400">
                                            {{ $myItem->claims->count() > 0 ? $myItem->claims->count() . ' Riwayat Permohonan' : 'Belum ada peminat' }}
                                        </span>
                                    @endif

                                    <a href="{{ route('items.show', $myItem) }}" 
                                       class="text-[11px] font-bold text-emerald-800 hover:text-emerald-950 transition-colors">
                                        Detail &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-emerald-50/60 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-white text-emerald-800 flex items-center justify-center shrink-0 border border-emerald-200">
                                <x-icon name="package" class="w-5 h-5 text-emerald-700" />
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Kamu belum memasang barang kuliah</h4>
                                <p class="text-[11px] text-gray-500">Punya buku modul, kalkulator, atau alat praktikum yang tak terpakai? Pasang sekarang!</p>
                            </div>
                        </div>
                        <a href="{{ route('items.create') }}" 
                           class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-bold transition-colors shrink-0">
                            <x-icon name="plus" class="w-3.5 h-3.5" />
                            <span>Pasang Barang Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>
        @endauth

        <!-- 2. Hero Section: Hub Komunitas Estafet Kampus (Solid Modern + Pattern) -->
        <div class="relative bg-white rounded-3xl p-7 sm:p-11 border border-gray-200/90 shadow-xs overflow-hidden">
            <!-- Decorative Architectural Dot Pattern (No Gradients) -->
            <div class="absolute inset-0 bg-[radial-gradient(#065f46_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Kolom Kiri: Headline & Pencarian Terpadu -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center space-x-2 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200/80 px-3.5 py-1.5 rounded-full">
                        <x-icon name="recycle" class="w-4 h-4 text-emerald-700" />
                        <span>Sirkulasi Berkah Antar Mahasiswa Satu Kampus</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-gray-900 tracking-tight leading-[1.15]">
                        Barang Nganggur?<br>
                        <span class="text-emerald-800">Biar Ada yang Pakai!</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-gray-600 max-w-xl leading-relaxed">
                        Platform sirkularitas kampus untuk saling menghibahkan, barter, atau beli barang kuliah murah sesama mahasiswa. Praktis tanpa komisi perantara, langsung COD di titik kumpul kampus.
                    </p>

                    <!-- Form Pencarian Interaktif Solid -->
                    <form action="{{ route('items.index') }}" method="GET" class="pt-1">
                        <div class="flex flex-col sm:flex-row items-center gap-2 bg-gray-50 p-2 rounded-2xl border border-gray-200 focus-within:bg-white focus-within:border-emerald-700 focus-within:ring-2 focus-within:ring-emerald-700/20 transition-all">
                            <div class="relative flex-grow w-full">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <x-icon name="search" class="w-4 h-4 text-gray-400" />
                                </span>
                                <input type="text" name="search" 
                                       placeholder="Cari buku kalkulus, jas lab, kemeja sidang, kalkulator..."
                                       class="w-full pl-10 pr-3 py-2 text-xs sm:text-sm border-0 focus:ring-0 text-gray-900 placeholder-gray-400 bg-transparent">
                            </div>
                            
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl transition-colors shrink-0 flex items-center justify-center space-x-1.5">
                                <span>Cari Barang</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </form>

                    <!-- Keyword Populer -->
                    <div class="flex flex-wrap items-center gap-2 text-[11px] text-gray-500 pt-0.5">
                        <span class="font-bold text-gray-700 flex items-center space-x-1">
                            <x-icon name="flame" class="w-3.5 h-3.5 text-amber-600" />
                            <span>Sering Dicari:</span>
                        </span>
                        <a href="{{ route('items.index', ['search' => 'Kalkulus']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Modul Kalkulus</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Jas Lab']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Jas Praktikum</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Casio']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Kalkulator Casio</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Almamater']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Jaket / Almet</a>
                    </div>
                </div>

                <!-- Kolom Kanan: Tiga Pilar Transaksi Solid (Clean Solid Cards) -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3.5">
                    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-2xl flex items-center space-x-4">
                        <div class="w-11 h-11 rounded-xl bg-white border border-emerald-200 text-emerald-800 flex items-center justify-center shrink-0 shadow-2xs">
                            <x-icon name="gift" class="w-5 h-5 text-emerald-800" />
                        </div>
                        <div>
                            <span class="text-[10px] text-emerald-800 font-bold uppercase tracking-wider block">Mode Gratis / Hibah</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Ambil Cuma-Cuma</span>
                            <p class="text-[11px] text-gray-600">Pahala & sirkulasi berkah tanpa gengsi</p>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl flex items-center space-x-4">
                        <div class="w-11 h-11 rounded-xl bg-white border border-amber-200 text-amber-700 flex items-center justify-center shrink-0 shadow-2xs">
                            <x-icon name="tag" class="w-5 h-5 text-amber-700" />
                        </div>
                        <div>
                            <span class="text-[10px] text-amber-800 font-bold uppercase tracking-wider block">Harga Pas Mahasiswa</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Jual Murah Ramah Kos</span>
                            <p class="text-[11px] text-gray-600">Tanpa potongan komisi perantara</p>
                        </div>
                    </div>

                    <div class="bg-teal-50 border border-teal-200 p-4 rounded-2xl flex items-center space-x-4">
                        <div class="w-11 h-11 rounded-xl bg-white border border-teal-200 text-teal-800 flex items-center justify-center shrink-0 shadow-2xs">
                            <x-icon name="repeat" class="w-5 h-5 text-teal-800" />
                        </div>
                        <div>
                            <span class="text-[10px] text-teal-800 font-bold uppercase tracking-wider block">Barter & Tukar Guling</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Saling Lengkapi Kebutuhan</span>
                            <p class="text-[11px] text-gray-600">Tukar buku/alat yang sepadan nilainya</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. Tiga Shortcut Mode Transaksi (Solid Cards & Explicit Colors) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Mode Gratis -->
            <a href="{{ route('items.index', ['mode' => 'gratis']) }}" 
               class="bg-white rounded-3xl p-6 border border-gray-200 hover:border-emerald-500 transition-all group flex flex-col justify-between shadow-2xs hover:shadow-xs">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center space-x-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-xl border border-emerald-200">
                            <x-icon name="gift" class="w-4 h-4 text-emerald-700" />
                            <span>Mode Gratis</span>
                        </span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-lg">100% Free</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-emerald-800 transition-colors">
                        Pahala & Hibah Bersih
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Ambil tanpa biaya apapun untuk kebutuhan kuliah tanpa gengsi. Bersih dari biaya tersembunyi.
                    </p>
                </div>
                <div class="mt-6 pt-3.5 border-t border-gray-100 text-xs font-bold text-emerald-800 flex items-center justify-between">
                    <span>Lihat barang gratisan</span>
                    <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>

            <!-- Mode Harga Pas -->
            <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" 
               class="bg-white rounded-3xl p-6 border border-gray-200 hover:border-amber-500 transition-all group flex flex-col justify-between shadow-2xs hover:shadow-xs">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center space-x-1.5 text-xs font-bold text-amber-800 bg-amber-50 px-3 py-1 rounded-xl border border-amber-200">
                            <x-icon name="tag" class="w-4 h-4 text-amber-700" />
                            <span>Mode Harga Pas</span>
                        </span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">Tanpa Nego</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-amber-800 transition-colors">
                        Jual Murah Anti Ribet
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Jual beli santai ramah kantong anak kos. Harga pas yang disepakati, bayar langsung pas COD.
                    </p>
                </div>
                <div class="mt-6 pt-3.5 border-t border-gray-100 text-xs font-bold text-amber-800 flex items-center justify-between">
                    <span>Cari barang terjangkau</span>
                    <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>

            <!-- Mode Barter -->
            <a href="{{ route('items.index', ['mode' => 'barter']) }}" 
               class="bg-white rounded-3xl p-6 border border-gray-200 hover:border-teal-500 transition-all group flex flex-col justify-between shadow-2xs hover:shadow-xs">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center space-x-1.5 text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-xl border border-teal-200">
                            <x-icon name="repeat" class="w-4 h-4 text-teal-700" />
                            <span>Mode Barter</span>
                        </span>
                        <span class="text-xs font-bold text-teal-700 bg-teal-100 px-2 py-0.5 rounded-lg">Tukar Barang</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-teal-800 transition-colors">
                        Tukar Guling Setara
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Tukaran barang yang sama-sama bermanfaat. Solusi hemat untuk saling melengkapi peralatan kuliah.
                    </p>
                </div>
                <div class="mt-6 pt-3.5 border-t border-gray-100 text-xs font-bold text-teal-800 flex items-center justify-between">
                    <span>Jelajahi opsi barter</span>
                    <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </div>
            </a>
        </div>

        <!-- 4. Pills Kategori Kebutuhan Kampus (Solid Styling) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 flex items-center space-x-1.5">
                    <x-icon name="folder" class="w-4 h-4 text-gray-400" />
                    <span>Kategori Perlengkapan Kuliah</span>
                </h3>
                <a href="{{ route('items.index') }}" class="text-xs font-bold text-emerald-800 hover:underline flex items-center space-x-1">
                    <span>Semua Kategori</span>
                    <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                </a>
            </div>
            
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none text-xs">
                <a href="{{ route('items.index') }}" 
                   class="px-4 py-2 rounded-2xl bg-emerald-800 text-white font-bold shrink-0">
                    Semua Barang
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('items.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-2xl bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-900 font-semibold border border-gray-200 transition-colors shrink-0 whitespace-nowrap">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 5. Listing Terbaru & Rekomendasi Kampus -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase text-emerald-800 tracking-wider">● Barang Segar Hari Ini</span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-0.5">
                        Listing Terbaru dari Teman Sekampus
                    </h2>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 flex items-center space-x-1">
                    <span>Lihat Semua Katalog</span>
                    <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                </a>
            </div>

            <!-- Grid 6 Kartu Barang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($recentItems as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-300 space-y-2">
                        <x-icon name="package" class="w-10 h-10 text-gray-400 mx-auto" />
                        <p class="text-sm font-bold text-gray-700">Belum ada barang yang dipasang saat ini.</p>
                        <p class="text-xs text-gray-400">Jadilah mahasiswa pertama yang menyalurkan barang kuliah di sini!</p>
                        <div class="pt-2">
                            <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-emerald-800 text-white rounded-xl text-xs font-bold">
                                <x-icon name="plus" class="w-4 h-4" />
                                <span>Pasang Barang Sekarang</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 6. Bottom Banner CTA: Komunitas Kampus (Solid Accent + Pattern) -->
        <div class="relative bg-emerald-900 rounded-3xl p-7 sm:p-9 text-white overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6">
            <!-- Subtle Dot Matrix Pattern -->
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>

            <div class="relative z-10 flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                    <x-icon name="package" class="w-7 h-7 text-emerald-200" />
                </div>
                <div class="space-y-1">
                    <h3 class="font-black text-base sm:text-lg">Punya barang kuliah yang sudah tidak terpakai?</h3>
                    <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed max-w-xl">
                        Bantu adik tingkat atau teman seangkatan yang membutuhkan. Cukup unggah foto dalam 1 menit dan tentukan apakah gratis, barter, atau harga pas!
                    </p>
                </div>
            </div>
            <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
               class="relative z-10 px-6 py-3.5 bg-white hover:bg-emerald-50 text-emerald-950 font-black text-xs sm:text-sm rounded-2xl transition-colors shrink-0 flex items-center space-x-2">
                <x-icon name="plus" class="w-4 h-4 text-emerald-900" />
                <span>Pasang Barang Sekarang</span>
            </a>
        </div>

    </div>
</x-app-layout>
