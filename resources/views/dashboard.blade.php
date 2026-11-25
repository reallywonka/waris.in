<x-app-layout>
    <div class="space-y-10 sm:space-y-12">
        
        <!-- 1. Header Sapaan Mahasiswa (Jika Login) -->
        @auth
            <div class="bg-waris-surface rounded-2xl p-5 border border-waris-border shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3.5">
                    <img class="w-11 h-11 rounded-full object-cover border border-waris-primary/20 shrink-0" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=065f46&color=ffffff' }}" 
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-base font-bold text-waris-text">
                                Halo, {{ Auth::user()->name }}
                            </h2>
                            <span class="inline-flex items-center space-x-1 text-xs font-medium bg-waris-primary-soft text-waris-primary px-2.5 py-0.5 rounded-full border border-waris-primary-border">
                                <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-muted"></span>
                                <span>Mahasiswa Aktif</span>
                            </span>
                        </div>
                        <p class="text-xs text-waris-subtle mt-0.5 flex items-center space-x-1.5">
                            <x-icon name="graduation-cap" class="w-3.5 h-3.5 text-waris-primary" />
                            <span>{{ Auth::user()->study_program ?? Auth::user()->faculty ?? 'Program Studi' }} &bull; Semester {{ Auth::user()->semester ?? '1' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Ringkasan Statistik & Tombol Pasang Cepat -->
                <div class="flex items-center space-x-2.5">
                    <div class="bg-waris-bg border border-waris-border rounded-xl px-3.5 py-2 flex items-center space-x-2.5">
                        <x-icon name="package" class="w-4 h-4 text-waris-primary" />
                        <div>
                            <span class="block text-xs font-semibold text-waris-text-secondary">{{ $userSharedCount }} Barang Terdaftar</span>
                        </div>
                    </div>
                    <a href="{{ route('items.create') }}" 
                       class="px-4 py-2 bg-waris-accent hover:bg-waris-accent-hover active:bg-waris-accent-active text-white font-semibold text-xs rounded-xl shadow-xs transition-colors shrink-0 flex items-center space-x-1.5 cursor-pointer">
                        <x-icon name="plus" class="w-4 h-4" />
                        <span>Pasang Barang</span>
                    </a>
                </div>
            </div>

            <!-- Section Barang Milik Kamu (Jika Ada) -->
            @if ($myItems->count() > 0)
                <div class="bg-waris-surface rounded-2xl p-6 border border-waris-border shadow-2xs space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-waris-surface-muted">
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-waris-text tracking-tight">
                                Barang yang Sedang Kamu Tawarkan / Jual
                            </h3>
                            <p class="text-xs text-waris-subtle">
                                Pantau ketersediaan dan respon peminat terhadap barang kuliahmu.
                            </p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('claims.incoming') }}" 
                               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border hover:bg-waris-accent-border/40 transition-colors">
                                <x-icon name="inbox" class="w-3.5 h-3.5 text-waris-accent" />
                                <span>Pengajuan Masuk ({{ $myPendingClaimsCount }})</span>
                            </a>
                            <a href="{{ route('items.my') }}" 
                               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-waris-primary hover:bg-waris-primary-soft transition-colors">
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
                            <div class="bg-waris-surface-hover hover:bg-waris-surface rounded-xl p-3 border border-waris-border hover:border-waris-primary-border transition-all flex flex-col justify-between group">
                                <div class="space-y-2.5">
                                    <div class="relative w-full aspect-4/3 rounded-lg overflow-hidden bg-waris-surface-muted border border-waris-border">
                                        <img src="{{ $myItem->primary_image_url }}" 
                                             alt="{{ $myItem->title }}"
                                             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';">
                                        
                                        <!-- Badge Status -->
                                        <div class="absolute top-2 left-2">
                                            @if ($myItem->status === 'available')
                                                <span class="inline-flex items-center space-x-1 text-xs font-medium px-2 py-0.5 rounded-md bg-waris-primary text-white shadow-2xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-border"></span>
                                                    <span>Tersedia</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center space-x-1 text-xs font-medium px-2 py-0.5 rounded-md bg-waris-text text-white shadow-2xs">
                                                    <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                                                    <span>Terkunci</span>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Badge Mode Transaksi -->
                                        <div class="absolute bottom-2 right-2">
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md shadow-2xs {{ $myItem->mode === 'harga_pas' ? 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border' : ($myItem->mode === 'barter' ? 'bg-waris-barter-soft text-waris-barter-text border border-waris-barter-border' : 'bg-waris-primary-soft text-waris-primary border border-waris-primary-border') }}">
                                                {{ $myItem->formatted_price }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('items.show', $myItem) }}" class="text-xs font-bold text-waris-text line-clamp-1 hover:text-waris-primary transition-colors">
                                            {{ $myItem->title }}
                                        </a>
                                        <div class="flex items-center justify-between text-xs text-waris-subtle mt-1">
                                            <span>{{ $myItem->category }}</span>
                                            <span>{{ $myItem->condition }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-waris-border flex items-center justify-between gap-2 text-xs">
                                    @if ($pendingClaims > 0)
                                        <a href="{{ route('claims.incoming', ['item_id' => $myItem->id]) }}" 
                                           class="inline-flex items-center space-x-1 font-semibold text-waris-accent-text bg-waris-accent-soft hover:bg-waris-accent-border/40 px-2 py-0.5 rounded-md transition-colors">
                                            <x-icon name="users" class="w-3 h-3 text-waris-accent" />
                                            <span>{{ $pendingClaims }} Peminat</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-waris-faint">
                                            {{ $myItem->claims->count() > 0 ? $myItem->claims->count() . ' Riwayat' : 'Belum ada peminat' }}
                                        </span>
                                    @endif

                                    <a href="{{ route('items.show', $myItem) }}" 
                                       class="font-semibold text-waris-primary hover:text-waris-primary-hover transition-colors">
                                        Detail &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        <!-- 2. Hero Section: Hub Komunitas Estafet Kampus -->
        <div class="bg-waris-surface rounded-2xl p-7 sm:p-10 border border-waris-border shadow-2xs">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Kolom Kiri: Headline & Pencarian -->
                <div class="lg:col-span-7 space-y-4">
                    <span class="inline-flex items-center space-x-1.5 text-xs font-semibold text-waris-primary bg-waris-primary-soft border border-waris-primary-border px-3 py-1 rounded-full">
                        <x-icon name="recycle" class="w-3.5 h-3.5 text-waris-primary-muted" />
                        <span>Platform Pertukaran & Hibah Kampus</span>
                    </span>

                    <h1 class="text-2xl sm:text-4xl font-bold text-waris-text tracking-tight leading-tight">
                        Oper barang kuliah yang sudah beres kamu pakai.
                    </h1>

                    <p class="text-xs sm:text-sm text-waris-muted max-w-xl leading-relaxed">
                        Tempat mahasiswa saling menghibahkan, barter, atau jual beli barang kuliah ramah kantong sesama rekan kampus. Tanpa perantara, langsung serah terima di kampus.
                    </p>

                    <!-- Form Pencarian Interaktif -->
                    <form action="{{ route('items.index') }}" method="GET" class="pt-1">
                        <div class="flex flex-col sm:flex-row items-center gap-2 bg-waris-bg p-2 rounded-xl border border-waris-border focus-within:bg-waris-surface focus-within:border-waris-primary focus-within:ring-2 focus-within:ring-waris-primary/20 transition-all">
                            <div class="relative flex-grow w-full">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-waris-faint">
                                    <x-icon name="search" class="w-4 h-4 text-waris-faint" />
                                </span>
                                <input type="text" name="search" 
                                       placeholder="Cari buku kalkulus, jas lab, kemeja sidang, kalkulator..."
                                       class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm border-0 focus:ring-0 text-waris-text placeholder-waris-faint bg-transparent">
                            </div>
                            
                            <button type="submit" 
                                    class="w-full sm:w-auto px-5 py-2.5 bg-waris-primary hover:bg-waris-primary-hover active:bg-waris-primary-active text-white font-semibold text-xs rounded-lg transition-colors shrink-0 flex items-center justify-center space-x-1.5 cursor-pointer">
                                <span>Cari Barang</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </form>

                    <!-- Keyword Populer -->
                    <div class="flex flex-wrap items-center gap-2 text-xs text-waris-subtle pt-0.5">
                        <span class="font-medium text-waris-text-secondary">Sering dicari:</span>
                        <a href="{{ route('items.index', ['search' => 'Kalkulus']) }}" class="text-waris-primary hover:underline">Buku Kalkulus</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Jas Lab']) }}" class="text-waris-primary hover:underline">Jas Lab</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Casio']) }}" class="text-waris-primary hover:underline">Kalkulator fx-991EX</a>
                        <span>&bull;</span>
                        <a href="{{ route('items.index', ['search' => 'Almamater']) }}" class="text-waris-primary hover:underline">Jaket Almamater</a>
                    </div>
                </div>

                <!-- Kolom Kanan: 3 Pilar Mode Transaksi -->
                <div class="lg:col-span-5 grid grid-cols-1 gap-3">
                    <a href="{{ route('items.index', ['mode' => 'gratis']) }}" 
                       class="bg-waris-primary-soft/70 hover:bg-waris-primary-soft border border-waris-primary-border/80 p-3.5 rounded-xl flex items-center space-x-3.5 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-waris-surface border border-waris-primary-border text-waris-primary flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                            <x-icon name="gift" class="w-5 h-5 text-waris-primary" />
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-bold text-waris-text block">Gratis (Hibah)</span>
                            <p class="text-xs text-waris-muted mt-0.5">Hibahkan untuk rekan yang membutuhkan tanpa biaya.</p>
                        </div>
                        <x-icon name="arrow-right" class="w-4 h-4 text-waris-primary-muted opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
                    </a>

                    <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" 
                       class="bg-waris-accent-soft/70 hover:bg-waris-accent-soft border border-waris-accent-border/80 p-3.5 rounded-xl flex items-center space-x-3.5 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-waris-surface border border-waris-accent-border text-waris-accent flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                            <x-icon name="tag" class="w-5 h-5 text-waris-accent" />
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-bold text-waris-text block">Harga Pas Mahasiswa</span>
                            <p class="text-xs text-waris-muted mt-0.5">Jual murah ramah kantong tanpa ribet tawar-menawar.</p>
                        </div>
                        <x-icon name="arrow-right" class="w-4 h-4 text-waris-accent opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
                    </a>

                    <a href="{{ route('items.index', ['mode' => 'barter']) }}" 
                       class="bg-waris-barter-soft/70 hover:bg-waris-barter-soft border border-waris-barter-border/80 p-3.5 rounded-xl flex items-center space-x-3.5 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-waris-surface border border-waris-barter-border text-waris-barter flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                            <x-icon name="repeat" class="w-5 h-5 text-waris-barter" />
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-bold text-waris-text block">Barter Barang</span>
                            <p class="text-xs text-waris-muted mt-0.5">Tukar dengan buku atau alat matkul lain yang kamu perlukan.</p>
                        </div>
                        <x-icon name="arrow-right" class="w-4 h-4 text-waris-barter opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
                    </a>
                </div>

            </div>
        </div>

        <!-- 3. Section Kategori Barang Kuliah -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-waris-subtle flex items-center space-x-1.5">
                    <x-icon name="folder" class="w-4 h-4 text-waris-faint" />
                    <span>Kategori Barang Kuliah</span>
                </h3>
                <a href="{{ route('items.index') }}" class="text-xs font-semibold text-waris-primary hover:underline flex items-center space-x-1">
                    <span>Semua Kategori</span>
                    <x-icon name="chevron-right" class="w-3.5 h-3.5 text-waris-primary" />
                </a>
            </div>
            
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none text-xs">
                <a href="{{ route('items.index') }}" 
                   class="px-3.5 py-1.5 rounded-xl bg-waris-primary text-white font-semibold shrink-0">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('items.index', ['category' => $cat]) }}" 
                       class="px-3.5 py-1.5 rounded-xl bg-waris-surface hover:bg-waris-primary-soft text-waris-text-secondary hover:text-waris-primary font-medium border border-waris-border transition-colors shrink-0 whitespace-nowrap">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 4. Section Listing Terbaru dari Rekan Kampus -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-waris-text tracking-tight">
                        Listing Terbaru dari Rekan Kampus
                    </h2>
                    <p class="text-xs text-waris-subtle mt-0.5">Barang-barang perkuliahan yang siap diajukan hari ini.</p>
                </div>
                <a href="{{ route('items.index') }}" class="text-xs font-semibold text-waris-primary hover:text-waris-primary-hover flex items-center space-x-1">
                    <span>Buka Katalog Lengkap</span>
                    <x-icon name="chevron-right" class="w-4 h-4 text-waris-primary" />
                </a>
            </div>

            <!-- Grid Kartu Barang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                @forelse ($recentItems as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-full text-center py-12 bg-waris-surface rounded-2xl border border-dashed border-waris-border-strong space-y-2">
                        <x-icon name="package" class="w-8 h-8 text-waris-faint mx-auto" />
                        <p class="text-sm font-semibold text-waris-text-secondary">Belum ada barang yang dipasang saat ini.</p>
                        <p class="text-xs text-waris-faint">Jadilah mahasiswa pertama yang mengoper barang kuliah di sini!</p>
                        <div class="pt-2">
                            <a href="{{ route('items.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-waris-accent hover:bg-waris-accent-hover text-white rounded-xl text-xs font-semibold shadow-xs">
                                <x-icon name="plus" class="w-4 h-4" />
                                <span>Pasang Barang Sekarang</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 5. Bottom Banner CTA -->
        <div class="bg-waris-primary-hover rounded-2xl p-7 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                    <x-icon name="package" class="w-6 h-6 text-waris-primary-border" />
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-base sm:text-lg">Punya perlengkapan kuliah yang tidak terpakai?</h3>
                    <p class="text-xs sm:text-sm text-waris-primary-soft/90 leading-relaxed max-w-xl">
                        Bantu adik tingkat atau teman seangkatan yang membutuhkan. Cukup pasang foto dan tentukan apakah gratis, barter, atau harga pas!
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
