<x-app-layout>
    <div class="space-y-10">
        
        <!-- 1. Header Sapaan Personal Mahasiswa (Jika Login) -->
        @auth
            <div class="bg-white/80 backdrop-blur rounded-2xl p-4 sm:p-5 border border-emerald-900/10 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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
                            {{ Auth::user()->faculty ?? 'Civitas Akademika' }} &bull; Kampus Utama
                        </p>
                    </div>
                </div>

                <!-- Badge Jejak Kebaikan -->
                <div class="bg-emerald-50/70 border border-emerald-200/60 rounded-xl px-4 py-2 flex items-center space-x-3 self-start sm:self-auto">
                    <span class="text-xl">🌱</span>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-emerald-800 tracking-wider">Jejak Kebaikan</span>
                        <span class="text-xs font-black text-gray-900">{{ $userSharedCount }} Barang Disalurkan</span>
                    </div>
                </div>
            </div>
        @endauth

        <!-- 2. Hero Section: "Barang Nganggur? Biar Ada yang Pakai!" -->
        <div class="relative bg-gradient-to-br from-white via-emerald-50/40 to-teal-50/40 rounded-3xl p-6 sm:p-10 border border-emerald-900/10 shadow-sm overflow-hidden text-center max-w-4xl mx-auto">
            <span class="inline-flex items-center text-xs font-bold text-emerald-800 uppercase tracking-widest bg-emerald-100/80 px-3.5 py-1 rounded-full mb-3">
                ♻️ Sirkulasi Berkah Antar Mahasiswa
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-gray-900 tracking-tight leading-tight">
                Barang Nganggur?<br><span class="text-emerald-800">Biar Ada yang Pakai!</span>
            </h1>
            <p class="mt-4 text-xs sm:text-sm text-gray-600 max-w-xl mx-auto leading-relaxed">
                Platform berbagi, barter, dan beli barang murah sesama mahasiswa kampus kita. Hemat pengeluaran, perpanjang usia barang, dan bangun koneksi pertemanan.
            </p>

            <!-- Search Bar Form -->
            <form action="{{ route('items.index') }}" method="GET" class="mt-8 max-w-2xl mx-auto flex flex-col sm:flex-row items-center gap-2 bg-white p-2 rounded-2xl shadow-md border border-gray-200/80">
                <div class="relative flex-grow w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        🔍
                    </span>
                    <input type="text" name="search" placeholder="Cari buku, jaket, kalkulator, modul praktikum..."
                           class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm border-0 focus:ring-0 text-gray-800 placeholder-gray-400 bg-transparent">
                </div>
                
                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0">
                        Cari Barang
                    </button>
                    <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                       class="w-full sm:w-auto px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0 text-center flex items-center justify-center space-x-1">
                        <span>+</span>
                        <span>Pasang Barang</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- 3. Tiga Shortcut Mode Transaksi (Sesuai Mockup 01, 02, 03) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Mode Gratis -->
            <a href="{{ route('items.index', ['mode' => 'gratis']) }}" 
               class="bg-white rounded-3xl p-6 border border-emerald-900/10 shadow-xs hover:shadow-md hover:border-emerald-300 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-xl">
                            🎁 Mode Gratis
                        </span>
                        <span class="text-xs font-mono font-bold text-gray-300">01</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-emerald-800 transition-colors">
                        Pahala & Hibah Bersih
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Ambil tanpa biaya apapun untuk kebutuhan kuliah tanpa gengsi.
                    </p>
                </div>
                <div class="mt-5 text-xs font-bold text-emerald-700 flex items-center space-x-1">
                    <span>Lihat hibahan</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>

            <!-- Mode Harga Pas -->
            <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" 
               class="bg-white rounded-3xl p-6 border border-emerald-900/10 shadow-xs hover:shadow-md hover:border-amber-300 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-xl">
                            🏷️ Mode Harga Pas
                        </span>
                        <span class="text-xs font-mono font-bold text-gray-300">02</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-amber-800 transition-colors">
                        Jual Beli Anti Ribet
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Jual beli santai ramah kantong kosan tanpa tawar-menawar drama.
                    </p>
                </div>
                <div class="mt-5 text-xs font-bold text-amber-700 flex items-center space-x-1">
                    <span>Barang terjangkau</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>

            <!-- Mode Barter -->
            <a href="{{ route('items.index', ['mode' => 'barter']) }}" 
               class="bg-white rounded-3xl p-6 border border-emerald-900/10 shadow-xs hover:shadow-md hover:border-teal-300 transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center text-xs font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-xl">
                            🔄 Mode Barter
                        </span>
                        <span class="text-xs font-mono font-bold text-gray-300">03</span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-gray-900 group-hover:text-teal-800 transition-colors">
                        Tukar Guling Setara
                    </h3>
                    <p class="mt-1.5 text-xs text-gray-500 leading-relaxed">
                        Tukaran barang yang sama-sama bermanfaat dan saling melengkapi.
                    </p>
                </div>
                <div class="mt-5 text-xs font-bold text-teal-700 flex items-center space-x-1">
                    <span>Jelajahi barter</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </a>
        </div>

        <!-- 4. Pills Kategori Kebutuhan Kampus -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">
                    Kategori Kebutuhan Kampus
                </h3>
                <span class="text-xs text-gray-400">7 Kategori Utama</span>
            </div>
            
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('items.index') }}" class="px-4 py-2 rounded-xl bg-emerald-800 text-white font-bold shadow-xs">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('items.index', ['category' => $cat]) }}" 
                       class="px-3.5 py-2 rounded-xl bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-900 font-medium border border-gray-200/80 transition-colors">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 5. Listing Terbaru & Rekomendasi Kampus -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="text-[11px] font-bold uppercase text-emerald-800 tracking-wider">Barang Segar Hari Ini</span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900">
                        Listing Terbaru & Rekomendasi Kampus
                    </h2>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs font-bold text-emerald-800 hover:underline flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- Grid 6 Kartu Barang -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($recentItems as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300">
                        <p class="text-sm text-gray-500">Belum ada barang yang dipasang saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 6. Bottom Banner CTA: Pasang Barang -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-2xl shrink-0">
                    📦
                </div>
                <div>
                    <h3 class="font-bold text-base sm:text-lg">Punya barang yang sudah tidak terpakai semester ini?</h3>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-0.5">
                        Bantu adik tingkat atau teman sejurusan yang membutuhkan. Pasang foto dalam 1 menit dan tentukan apakah gratis, barter, atau harga pas!
                    </p>
                </div>
            </div>
            <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
               class="px-6 py-3 bg-white hover:bg-emerald-50 text-emerald-900 font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors shrink-0 flex items-center space-x-2">
                <span>➕</span>
                <span>Pasang Barang Sekarang</span>
            </a>
        </div>

    </div>
</x-app-layout>
