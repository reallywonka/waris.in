<x-app-layout>
    <div class="space-y-8">
        
        <!-- 1. Header Katalog & Stats Counter -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-2">
            <div>
                <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100/70 px-3 py-1 rounded-full mb-2">
                    ● Katalog Kampus Terintegrasi
                </span>
                <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
                    Cari Barang yang Kamu Butuhkan
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-xl">
                    Jelajahi ratusan barang dari mahasiswa di seluruh fakultas. Praktis, hemat, dan dukung sirkularitas kampus!
                </p>
            </div>

            <!-- Stats Bar Kanan (Sesuai Mockup) -->
            <div class="flex items-center space-x-3 bg-white p-3 rounded-2xl border border-gray-100 shadow-xs self-start lg:self-auto shrink-0">
                <div class="text-center px-4 border-r border-gray-100">
                    <span class="block text-xl font-black text-gray-900">{{ $totalListing }}</span>
                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Total Listing</span>
                </div>
                <div class="text-center px-4 border-r border-gray-100">
                    <span class="block text-xl font-black text-emerald-700">{{ $gratisCount }}</span>
                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Gratis Tersedia</span>
                </div>
                <div class="text-center px-4">
                    <span class="block text-xl font-black text-teal-700">{{ $fakultasCount }}</span>
                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Fakultas Aktif</span>
                </div>
            </div>
        </div>

        <!-- 2. Form Filter & Pencarian Lengkap -->
        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-sm space-y-4">
            <form action="{{ route('items.index') }}" method="GET" class="space-y-4">
                
                <!-- Baris 1: Search Bar + Filter Fakultas + Tombol Cari -->
                <div class="flex flex-col md:flex-row items-center gap-3">
                    <div class="relative flex-grow w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            🔍
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul barang, kalkulator, modul, jas lab..."
                               class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50/50">
                    </div>

                    <!-- Dropdown Fakultas -->
                    <div class="w-full md:w-56 shrink-0">
                        <select name="faculty" class="w-full py-2.5 text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50/50">
                            <option value="Semua">🏛️ Semua Fakultas</option>
                            @foreach ($faculties as $fac)
                                <option value="{{ $fac }}" {{ request('faculty') === $fac ? 'selected' : '' }}>
                                    {{ $fac }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0 flex items-center justify-center space-x-2">
                        <span>Cari</span>
                        <span>&rarr;</span>
                    </button>
                </div>

                <!-- Baris 2: Filter Mode Pills + Kategori + Kondisi + Checkbox Tersedia -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-gray-100 text-xs">
                    
                    <!-- Mode Pills Toggle -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => ''])) }}"
                           class="px-3 py-1.5 rounded-xl font-bold transition-all {{ !request('mode') ? 'bg-emerald-900 text-white shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Semua <span class="text-[10px] opacity-80">({{ $totalListing }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'gratis'])) }}"
                           class="px-3 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'gratis' ? 'bg-emerald-800 text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                            🎁 Gratis <span class="text-[10px] opacity-80">({{ $gratisCount }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'harga_pas'])) }}"
                           class="px-3 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'harga_pas' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                            🏷️ Harga Pas <span class="text-[10px] opacity-80">({{ $hargaPasCount }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'barter'])) }}"
                           class="px-3 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'barter' ? 'bg-teal-700 text-white shadow-xs' : 'bg-teal-50 text-teal-800 hover:bg-teal-100' }}">
                            🔄 Barter <span class="text-[10px] opacity-80">({{ $barterCount }})</span>
                        </a>
                    </div>

                    <!-- Dropdown Kategori & Kondisi & Checkbox -->
                    <div class="flex flex-wrap items-center gap-2">
                        <select name="category" onchange="this.form.submit()" class="py-1.5 px-3 text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50">
                            <option value="Semua">Semua Kategori</option>
                            <option value="Buku" {{ request('category') === 'Buku' ? 'selected' : '' }}>Buku & Modul</option>
                            <option value="Elektronik" {{ request('category') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Perlengkapan" {{ request('category') === 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan Kuliah</option>
                            <option value="Fashion" {{ request('category') === 'Fashion' ? 'selected' : '' }}>Fashion & Jaket</option>
                            <option value="Praktikum" {{ request('category') === 'Praktikum' ? 'selected' : '' }}>Alat Praktikum</option>
                        </select>

                        <select name="condition" onchange="this.form.submit()" class="py-1.5 px-3 text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50">
                            <option value="Semua">Semua Kondisi</option>
                            <option value="Baru (Gress)" {{ request('condition') === 'Baru (Gress)' ? 'selected' : '' }}>Baru (Gress)</option>
                            <option value="Seperti Baru" {{ request('condition') === 'Seperti Baru' ? 'selected' : '' }}>Seperti Baru</option>
                            <option value="Bekas Layak Pakai" {{ request('condition') === 'Bekas Layak Pakai' ? 'selected' : '' }}>Bekas Layak Pakai</option>
                            <option value="Ada Kekurangan" {{ request('condition') === 'Ada Kekurangan' ? 'selected' : '' }}>Ada Kekurangan</option>
                        </select>

                        <label class="inline-flex items-center cursor-pointer ml-1">
                            <input type="checkbox" name="available_only" value="1" onchange="this.form.submit()"
                                   {{ request('available_only') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-emerald-800 shadow-xs focus:ring-emerald-700">
                            <span class="ms-1.5 text-xs text-gray-700 font-medium">Hanya yang Tersedia</span>
                        </label>
                    </div>

                </div>
            </form>
        </div>

        <!-- 3. Status Hasil Pencarian & Sorting -->
        <div class="flex items-center justify-between text-xs text-gray-500 font-medium px-1">
            <div class="flex items-center space-x-1">
                <span>📦</span>
                <span>Menampilkan <strong class="text-gray-900">{{ $items->total() }}</strong> barang aktif</span>
            </div>

            <!-- Sorting Dropdown -->
            <form action="{{ route('items.index') }}" method="GET" class="flex items-center space-x-1.5">
                @foreach (request()->except('sort', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <span>Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="text-xs py-1 px-2.5 rounded-lg border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 font-semibold text-gray-800 bg-white">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru Masuk</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </form>
        </div>

        <!-- 4. Grid Kartu Barang -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($items as $item)
                <x-item-card :item="$item" />
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                    <div class="text-4xl mb-2">🔍</div>
                    <h4 class="font-bold text-gray-800 text-base">Tidak ada barang yang cocok</h4>
                    <p class="text-xs text-gray-500 mt-1">Coba gunakan kata kunci lain atau reset filter pencarian kamu.</p>
                    <a href="{{ route('items.index') }}" class="inline-block mt-4 px-4 py-2 bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs">
                        Reset Semua Filter
                    </a>
                </div>
            @endforelse
        </div>

        <!-- 5. Pagination Link -->
        <div class="pt-4">
            {{ $items->links() }}
        </div>

        <!-- 6. Bottom Banner CTA -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-2xl shrink-0">
                    ♻️
                </div>
                <div>
                    <h3 class="font-bold text-base sm:text-lg">Punya barang yang nganggur di kosan?</h3>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-0.5">
                        Bantu teman kampusmu yang sedang butuh alat praktikum, buku, atau perabotan. Pasang sekarang dalam 1 menit!
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
