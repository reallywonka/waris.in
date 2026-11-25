<x-app-layout>
    <div class="space-y-8 pb-12">
        
        <!-- 1. Header Katalog & Stats Counter -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-2">
            <div>
                <span class="inline-flex items-center space-x-1.5 text-xs font-semibold text-waris-primary bg-waris-primary-soft border border-waris-primary-border px-3 py-1 rounded-full mb-2">
                    <x-icon name="building" class="w-3.5 h-3.5 text-waris-primary" />
                    <span>Katalog Kampus</span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                    Cari Perlengkapan Kuliah
                </h1>
                <p class="text-xs sm:text-sm text-waris-muted mt-1 max-w-xl leading-relaxed">
                    Jelajahi perlengkapan kuliah dari sesama rekan kampus. Hibahkan, barter, atau beli barang ramah kantong langsung COD di kampus.
                </p>
            </div>

            <!-- Stats Bar Kanan -->
            <div class="flex items-center space-x-3 bg-waris-surface p-3.5 rounded-xl border border-waris-border shadow-2xs self-start lg:self-auto shrink-0">
                <div class="text-center px-4 border-r border-waris-surface-muted">
                    <span class="block text-xl font-bold text-waris-text">{{ $totalListing }}</span>
                    <span class="text-xs text-waris-faint font-medium">Total Listing</span>
                </div>
                <div class="text-center px-4 border-r border-waris-surface-muted">
                    <span class="block text-xl font-bold text-waris-primary-muted">{{ $gratisCount }}</span>
                    <span class="text-xs text-waris-faint font-medium">Gratis</span>
                </div>
                <div class="text-center px-4">
                    <span class="block text-xl font-bold text-waris-barter">{{ $fakultasCount }}</span>
                    <span class="text-xs text-waris-faint font-medium">Fakultas</span>
                </div>
            </div>
        </div>

        <!-- 2. Form Filter & Pencarian Lengkap -->
        <div class="bg-waris-surface rounded-2xl p-5 sm:p-6 border border-waris-border shadow-2xs space-y-4">
            <form action="{{ route('items.index') }}" method="GET" class="space-y-4">
                
                <!-- Baris 1: Search Bar + Filter Fakultas + Tombol Cari -->
                <div class="flex flex-col md:flex-row items-center gap-3">
                    <div class="relative flex-grow w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-waris-faint">
                            <x-icon name="search" class="w-4 h-4 text-waris-faint" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul barang, kalkulator, modul, jas praktikum..."
                               class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary bg-waris-surface-hover text-waris-text">
                    </div>

                    <!-- Dropdown Fakultas -->
                    <div class="w-full md:w-56 shrink-0">
                        <select name="faculty" class="w-full py-2.5 text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary bg-waris-surface-hover text-waris-text font-medium">
                            <option value="Semua">Semua Fakultas</option>
                            @foreach ($faculties as $fac)
                                <option value="{{ $fac }}" {{ request('faculty') === $fac ? 'selected' : '' }}>
                                    {{ $fac }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Cari Solid -->
                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-waris-primary hover:bg-waris-primary-hover text-white font-bold text-xs rounded-xl transition-colors shrink-0 flex items-center justify-center space-x-2 cursor-pointer">
                        <span>Cari Barang</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </button>
                </div>

                <!-- Baris 2: Filter Mode Pills + Kategori + Kondisi + Checkbox Tersedia -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-waris-surface-muted text-xs">
                    
                    <!-- Mode Pills Toggle Solid -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => ''])) }}"
                           class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ !request('mode') ? 'bg-waris-primary-hover text-white' : 'bg-waris-surface-muted text-waris-text-secondary hover:bg-waris-border' }}">
                            Semua <span class="text-[10px] opacity-80">({{ $totalListing }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'gratis'])) }}"
                           class="inline-flex items-center space-x-1 px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'gratis' ? 'bg-waris-primary text-white' : 'bg-waris-primary-soft text-waris-primary border border-waris-primary-border hover:bg-waris-primary-border/40' }}">
                            <x-icon name="gift" class="w-3.5 h-3.5 {{ request('mode') === 'gratis' ? 'text-white' : 'text-waris-primary-muted' }}" />
                            <span>Gratis</span>
                            <span class="text-[10px] opacity-80">({{ $gratisCount }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'harga_pas'])) }}"
                           class="inline-flex items-center space-x-1 px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'harga_pas' ? 'bg-waris-accent text-white' : 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border hover:bg-waris-accent-border/40' }}">
                            <x-icon name="tag" class="w-3.5 h-3.5 {{ request('mode') === 'harga_pas' ? 'text-white' : 'text-waris-accent' }}" />
                            <span>Harga Pas</span>
                            <span class="text-[10px] opacity-80">({{ $hargaPasCount }})</span>
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->except('mode', 'page'), ['mode' => 'barter'])) }}"
                           class="inline-flex items-center space-x-1 px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('mode') === 'barter' ? 'bg-waris-barter text-white' : 'bg-waris-barter-soft text-waris-barter-text border border-waris-barter-border hover:bg-waris-barter-border/40' }}">
                            <x-icon name="repeat" class="w-3.5 h-3.5 {{ request('mode') === 'barter' ? 'text-white' : 'text-waris-barter' }}" />
                            <span>Barter</span>
                            <span class="text-[10px] opacity-80">({{ $barterCount }})</span>
                        </a>
                    </div>

                    <!-- Dropdown Kategori & Kondisi & Checkbox -->
                    <div class="flex flex-wrap items-center gap-2">
                        <select name="category" onchange="this.form.submit()" class="py-1.5 px-3 text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary bg-waris-surface-hover text-waris-text font-medium">
                            <option value="Semua">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>

                        <select name="condition" onchange="this.form.submit()" class="py-1.5 px-3 text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary bg-waris-surface-hover text-waris-text font-medium">
                            <option value="Semua">Semua Kondisi</option>
                            <option value="Baru (Gress)" {{ request('condition') === 'Baru (Gress)' ? 'selected' : '' }}>Baru (Gress)</option>
                            <option value="Seperti Baru" {{ request('condition') === 'Seperti Baru' ? 'selected' : '' }}>Seperti Baru</option>
                            <option value="Bekas Layak Pakai" {{ request('condition') === 'Bekas Layak Pakai' ? 'selected' : '' }}>Bekas Layak Pakai</option>
                            <option value="Ada Kekurangan" {{ request('condition') === 'Ada Kekurangan' ? 'selected' : '' }}>Ada Kekurangan</option>
                        </select>

                        <label class="inline-flex items-center cursor-pointer ml-1 select-none">
                            <input type="checkbox" name="available_only" value="1" onchange="this.form.submit()"
                                   {{ request('available_only') ? 'checked' : '' }}
                                   class="rounded border-waris-border-strong text-waris-primary shadow-2xs focus:ring-waris-primary cursor-pointer">
                            <span class="ms-1.5 text-xs text-waris-text-secondary font-semibold">Tersedia Saja</span>
                        </label>
                    </div>

                </div>
            </form>
        </div>

        <!-- 3. Status Hasil Pencarian & Sorting -->
        <div class="flex items-center justify-between text-xs text-waris-subtle font-medium px-1">
            <div class="flex items-center space-x-1.5">
                <x-icon name="package" class="w-3.5 h-3.5 text-waris-faint" />
                <span>Menampilkan <strong class="text-waris-text font-bold">{{ $items->total() }}</strong> barang di kampus</span>
            </div>

            <!-- Sorting Dropdown -->
            <form action="{{ route('items.index') }}" method="GET" class="flex items-center space-x-1.5">
                @foreach (request()->except('sort', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <span>Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="text-xs py-1 px-2.5 rounded-lg border-waris-border focus:border-waris-primary focus:ring-waris-primary font-semibold text-waris-text bg-waris-surface">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru Masuk</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </form>
        </div>

        <!-- 4. Grid Kartu Barang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($items as $item)
                <x-item-card :item="$item" />
            @empty
                <div class="col-span-3 text-center py-16 bg-waris-surface rounded-3xl border border-dashed border-waris-border-strong space-y-2">
                    <x-icon name="search" class="w-10 h-10 text-waris-faint mx-auto" />
                    <h4 class="font-bold text-waris-text text-base">Tidak ada barang yang cocok</h4>
                    <p class="text-xs text-waris-subtle max-w-sm mx-auto">
                        Coba gunakan kata kunci pencarian yang lebih umum atau reset filter yang sedang aktif.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-waris-primary text-white font-bold text-xs rounded-xl shadow-xs hover:bg-waris-primary-hover transition-colors">
                            Reset Semua Filter
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- 5. Pagination Link -->
        <div class="pt-4">
            {{ $items->links() }}
        </div>

        <!-- 6. Bottom Banner CTA -->
        <div class="bg-waris-primary-hover rounded-2xl p-7 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                    <x-icon name="recycle" class="w-6 h-6 text-waris-primary-border" />
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-base sm:text-lg">Punya barang kuliah nganggur di kosan?</h3>
                    <p class="text-xs sm:text-sm text-waris-primary-soft/90 leading-relaxed max-w-xl">
                        Bantu teman kampusmu yang sedang butuh alat praktikum, buku, atau perlengkapan kuliah. Pasang sekarang dalam hitungan menit!
                    </p>
                </div>
            </div>
            <a href="{{ route('items.create') }}" 
               class="px-5 py-3 bg-waris-accent hover:bg-waris-accent-hover active:bg-waris-accent-active text-white font-bold text-xs sm:text-sm rounded-xl transition-colors shrink-0 flex items-center space-x-2 shadow-xs cursor-pointer">
                <x-icon name="plus" class="w-4 h-4 text-white" />
                <span>Pasang Barang Sekarang</span>
            </a>
        </div>

    </div>
</x-app-layout>
