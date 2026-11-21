<x-app-layout>
    <div class="space-y-12">
        
        <!-- 1. Header Sapaan Personal Mahasiswa (Jika Login) -->
        @auth
            <div class="bg-white rounded-3xl p-5 border border-emerald-900/10 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3.5">
                    <img class="w-12 h-12 rounded-full object-cover border-2 border-emerald-700/20 shadow-xs" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-base sm:text-lg font-black text-gray-900">
                                Hai, {{ Auth::user()->name }}! 👋
                            </h2>
                            <span class="inline-flex items-center text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">
                                ● Mahasiswa Aktif
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ Auth::user()->faculty ?? 'Civitas Akademika' }} &bull; Angkatan {{ Auth::user()->batch ?? 'Kampus' }}
                        </p>
                    </div>
                </div>

                <!-- Badge Jejak Kebaikan Mahasiswa -->
                <div class="flex items-center space-x-2.5">
                    <div class="bg-emerald-50 border border-emerald-200/80 rounded-2xl px-4 py-2 flex items-center space-x-3">
                        <span class="text-xl">🌱</span>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-emerald-800 tracking-wider">Jejak Kebaikan</span>
                            <span class="text-xs font-black text-gray-900">{{ $userSharedCount }} Barang Disalurkan</span>
                        </div>
                    </div>
                    <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                       class="px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-2xl shadow-xs transition-colors shrink-0 flex items-center space-x-1.5">
                        <span>+</span>
                        <span>Pasang Barang</span>
                    </a>
                </div>
            </div>
        @endauth

        <!-- 2. Hero Section: Hub Komunitas Estafet Kampus (Anti-Slop Craft) -->
        <div class="relative bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/20 rounded-3xl p-6 sm:p-10 border border-emerald-900/10 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Kolom Kiri: Headline & Pencarian Terpadu -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center space-x-2 text-xs font-bold text-emerald-800 bg-emerald-100/70 px-3.5 py-1 rounded-full">
                        <span>♻️</span>
                        <span>Sirkulasi Berkah Antar Mahasiswa Satu Kampus</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-gray-900 tracking-tight leading-[1.15]">
                        Barang Nganggur?<br>
                        <span class="text-emerald-800">Biar Ada yang Pakai!</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-gray-600 max-w-xl leading-relaxed">
                        Platform sirkularitas kampus untuk saling menghibahkan, barter, atau beli barang kuliah murah sesama mahasiswa. Praktis tanpa komisi perantara, langsung COD di titik kumpul kampus.
                    </p>

                    <!-- Form Pencarian Interaktif -->
                    <form action="{{ route('items.index') }}" method="GET" class="pt-2">
                        <div class="flex flex-col sm:flex-row items-center gap-2 bg-white p-2 rounded-2xl shadow-md border border-gray-200/90 focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 transition-all">
                            <div class="relative flex-grow w-full">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    🔍
                                </span>
                                <input type="text" name="search" 
                                       placeholder="Cari buku kalkulus, jas lab, kemeja sidang, kalkulator..."
                                       class="w-full pl-10 pr-3 py-2 text-xs sm:text-sm border-0 focus:ring-0 text-gray-900 placeholder-gray-400 bg-transparent">
                            </div>
                            
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0 flex items-center justify-center space-x-1.5">
                                <span>Cari Barang</span>
                                <span>&rarr;</span>
                            </button>
                        </div>
                    </form>

                    <!-- Keyword Populer -->
                    <div class="flex flex-wrap items-center gap-2 text-[11px] text-gray-500 pt-1">
                        <span class="font-bold text-gray-700">🔥 Sering Dicari:</span>
                        <a href="{{ route('items.index', ['search' => 'Kalkulus']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Modul Kalkulus</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Jas Lab']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Jas Praktikum</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Casio']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Kalkulator Casio</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Almamater']) }}" class="hover:text-emerald-800 underline decoration-gray-300">Jaket / Almet</a>
                    </div>
                </div>

                <!-- Kolom Kanan: Kartu Metrik Kampus (Data-Driven, Not Slop) -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3.5">
                    <div class="bg-white/90 backdrop-blur-xs p-4 rounded-2xl border border-emerald-900/10 shadow-2xs flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl shrink-0 font-bold">
                            🎁
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase block">Mode Gratis / Hibah</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Ambil Cuma-Cuma</span>
                            <p class="text-[11px] text-gray-500">Pahala & sirkulasi berkah tanpa gengsi</p>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur-xs p-4 rounded-2xl border border-amber-900/10 shadow-2xs flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl shrink-0 font-bold">
                            🏷️
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase block">Harga Pas Mahasiswa</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Jual Murah Ramah Kos</span>
                            <p class="text-[11px] text-gray-500">Tanpa potongan komisi perantara</p>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur-xs p-4 rounded-2xl border border-teal-900/10 shadow-2xs flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center text-xl shrink-0 font-bold">
                            🔄
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase block">Barter & Tukar Guling</span>
                            <span class="text-sm font-bold text-gray-900 block mt-0.5">Saling Lengkapi Kebutuhan</span>
                            <p class="text-[11px] text-gray-500">Tukar buku/alat yang sepadan nilainya</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. Tiga Shortcut Mode Transaksi (Bespoke Palette & Visual Personality) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Mode Gratis -->
            <a href="{{ route('items.index', ['mode' => 'gratis']) }}" 
               class="bg-white rounded-3xl p-6 border border-emerald-900/10 shadow-xs hover:shadow-md hover:border-emerald-400 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-xl border border-emerald-100/60">
                            🎁 Mode Gratis
                        </span>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-100/60 px-2 py-0.5 rounded-lg">100% Free</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-emerald-800 transition-colors">
                        Pahala & Hibah Bersih
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Ambil tanpa biaya apapun untuk kebutuhan kuliah tanpa gengsi. Bersih dari biaya tersembunyi.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-gray-100 text-xs font-bold text-emerald-700 flex items-center justify-between">
                    <span>Lihat barang gratisan</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>

            <!-- Mode Harga Pas -->
            <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" 
               class="bg-white rounded-3xl p-6 border border-amber-900/10 shadow-xs hover:shadow-md hover:border-amber-400 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-amber-800 bg-amber-50 px-3 py-1 rounded-xl border border-amber-100/60">
                            🏷️ Mode Harga Pas
                        </span>
                        <span class="text-xs font-bold text-amber-600 bg-amber-100/60 px-2 py-0.5 rounded-lg">Tanpa Nego</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-amber-800 transition-colors">
                        Jual Murah Anti Ribet
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Jual beli santai ramah kantong anak kos. Harga pas yang disepakati, bayar langsung pas COD.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-gray-100 text-xs font-bold text-amber-700 flex items-center justify-between">
                    <span>Cari barang terjangkau</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>

            <!-- Mode Barter -->
            <a href="{{ route('items.index', ['mode' => 'barter']) }}" 
               class="bg-white rounded-3xl p-6 border border-teal-900/10 shadow-xs hover:shadow-md hover:border-teal-400 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-xl border border-teal-100/60">
                            🔄 Mode Barter
                        </span>
                        <span class="text-xs font-bold text-teal-600 bg-teal-100/60 px-2 py-0.5 rounded-lg">Tukar Barang</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-teal-800 transition-colors">
                        Tukar Guling Setara
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Tukaran barang yang sama-sama bermanfaat. Solusi hemat untuk saling melengkapi peralatan kuliah.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-gray-100 text-xs font-bold text-teal-700 flex items-center justify-between">
                    <span>Jelajahi opsi barter</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>
        </div>

        <!-- 4. Pills Kategori Kebutuhan Kampus (Thumb-Friendly Horizontal Scroll) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 flex items-center space-x-1.5">
                    <span>📂</span>
                    <span>Kategori Perlengkapan Kuliah</span>
                </h3>
                <a href="{{ route('items.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">
                    Semua Kategori &rarr;
                </a>
            </div>
            
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none text-xs">
                <a href="{{ route('items.index') }}" 
                   class="px-4 py-2 rounded-2xl bg-emerald-800 text-white font-bold shadow-2xs shrink-0">
                    Semua Barang
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('items.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-2xl bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-900 font-medium border border-gray-200/80 transition-colors shrink-0 whitespace-nowrap">
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
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- Grid 6 Kartu Barang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($recentItems as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-300 space-y-2">
                        <span class="text-3xl block">📦</span>
                        <p class="text-sm font-bold text-gray-700">Belum ada barang yang dipasang saat ini.</p>
                        <p class="text-xs text-gray-400">Jadilah mahasiswa pertama yang menyalurkan barang kuliah di sini!</p>
                        <div class="pt-2">
                            <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" class="inline-flex items-center px-4 py-2 bg-emerald-800 text-white rounded-xl text-xs font-bold">
                                Pasang Barang Sekarang
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 6. Bottom Banner CTA: Komunitas Kampus -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-3xl shrink-0">
                    📦
                </div>
                <div class="space-y-1">
                    <h3 class="font-black text-base sm:text-lg">Punya barang kuliah yang sudah tidak terpakai?</h3>
                    <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed max-w-xl">
                        Bantu adik tingkat atau teman seangkatan yang membutuhkan. Cukup unggah foto dalam 1 menit dan tentukan apakah gratis, barter, atau harga pas!
                    </p>
                </div>
            </div>
            <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
               class="px-6 py-3.5 bg-white hover:bg-emerald-50 text-emerald-900 font-black text-xs sm:text-sm rounded-2xl shadow-xs transition-colors shrink-0 flex items-center space-x-2">
                <span>+</span>
                <span>Pasang Barang Sekarang</span>
            </a>
        </div>

    </div>
</x-app-layout>
