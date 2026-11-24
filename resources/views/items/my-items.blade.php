<x-app-layout>
    <div class="space-y-8 pb-16">

        <!-- 1. Header Halaman & Tombol Aksi -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-waris-border">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-waris-subtle mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-waris-text font-bold">Barang Saya</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                    Manajemen Barang Saya
                </h1>
                <p class="text-xs sm:text-sm text-waris-subtle mt-1">
                    Kelola dan pantau seluruh perlengkapan kuliah yang Anda pasang di katalog waris.in.
                </p>
            </div>

            <div class="flex items-center space-x-2.5">
                <a href="{{ route('claims.incoming') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-surface border border-waris-border hover:border-waris-primary-border text-waris-text-secondary hover:text-waris-primary rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <x-icon name="inbox" class="w-4 h-4 text-waris-primary-muted" />
                    <span>Semua Pengajuan Masuk</span>
                </a>
                <a href="{{ route('items.create') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-accent hover:bg-waris-accent-hover text-white rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <x-icon name="plus" class="w-4 h-4" />
                    <span>Pasang Barang Baru</span>
                </a>
            </div>
        </div>

        <!-- 2. Ringkasan Statistik Barang -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Total Terpasang</span>
                    <span class="text-2xl font-bold text-waris-text block mt-1">{{ $totalItems }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary flex items-center justify-center border border-waris-primary-border">
                    <x-icon name="package" class="w-5 h-5" />
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Barang Tersedia</span>
                    <span class="text-2xl font-bold text-waris-primary-muted block mt-1">{{ $availableItems }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary flex items-center justify-center border border-waris-primary-border">
                    <span class="w-3 h-3 rounded-full bg-waris-primary-muted animate-pulse"></span>
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Terkunci (Deal)</span>
                    <span class="text-2xl font-bold text-waris-text-secondary block mt-1">{{ $lockedItems }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-surface-hover text-waris-muted flex items-center justify-center border border-waris-border">
                    <x-icon name="lock" class="w-5 h-5" />
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Peminat Masuk</span>
                    <span class="text-2xl font-bold text-waris-accent block mt-1">{{ $totalClaimsReceived }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-accent-soft text-waris-accent-text flex items-center justify-center border border-waris-accent-border">
                    <x-icon name="inbox" class="w-5 h-5" />
                </div>
            </div>
        </div>

        <!-- 3. Filter Status Barang -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-none text-xs font-bold">
            <a href="{{ route('items.my', array_merge(request()->except('status', 'page'), ['status' => ''])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all {{ !request()->filled('status') ? 'bg-waris-primary text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                Semua Barang ({{ $totalItems }})
            </a>
            <a href="{{ route('items.my', array_merge(request()->except('status', 'page'), ['status' => 'available'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'available' ? 'bg-waris-primary-muted text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                <span class="w-2 h-2 rounded-full bg-waris-primary-border"></span>
                <span>Tersedia ({{ $availableItems }})</span>
            </a>
            <a href="{{ route('items.my', array_merge(request()->except('status', 'page'), ['status' => 'locked'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'locked' ? 'bg-waris-text text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-text' }}">
                <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                <span>Terkunci / Selesai ({{ $lockedItems }})</span>
            </a>
        </div>

        <!-- 4. Daftar Barang -->
        @if ($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($items as $item)
                    <div class="bg-waris-surface rounded-3xl border border-waris-border shadow-2xs p-5 flex flex-col justify-between transition-all hover:border-waris-border-strong">
                        <div class="space-y-3.5">
                            
                            <!-- Header Kartu -->
                            <div class="flex items-start space-x-3.5">
                                <img src="{{ $item->primary_image_url }}" 
                                     alt="{{ $item->title }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                     class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover border border-waris-border shrink-0">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold {{ $item->mode === 'harga_pas' ? 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border' : ($item->mode === 'barter' ? 'bg-waris-barter-soft text-waris-barter-text border border-waris-barter-border' : 'bg-waris-primary-soft text-waris-primary border border-waris-primary-border') }}">
                                            {{ $item->formatted_price }}
                                        </span>
                                        @if ($item->status === 'available')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-waris-primary-soft text-waris-primary-muted border border-waris-primary-border">
                                                ● Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-waris-surface-muted text-waris-muted border border-waris-border">
                                                <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                                                <span>Terkunci</span>
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('items.show', $item) }}" class="text-sm font-bold text-waris-text hover:text-waris-primary transition-colors line-clamp-1">
                                        {{ $item->title }}
                                    </a>
                                    <span class="text-[11px] text-waris-faint block mt-0.5">
                                        {{ $item->category }} &bull; {{ $item->condition }}
                                    </span>
                                </div>
                            </div>

                            <!-- Info Lokasi & Jumlah Peminat -->
                            <div class="bg-waris-surface-hover p-3 rounded-2xl border border-waris-surface-muted text-[11px] flex items-center justify-between">
                                <span class="text-waris-subtle truncate max-w-[60%] flex items-center space-x-1">
                                    <x-icon name="map-pin" class="w-3.5 h-3.5 text-waris-faint shrink-0" />
                                    <span class="truncate">{{ $item->meetup_location ?? 'Sekitar Kampus' }}</span>
                                </span>
                                <a href="{{ route('claims.incoming', ['item_id' => $item->id]) }}" 
                                   class="font-bold {{ $item->claims->count() > 0 ? 'text-waris-accent-text bg-waris-accent-soft border border-waris-accent-border px-2.5 py-0.5 rounded-lg' : 'text-waris-faint' }}">
                                    {{ $item->claims->count() }} Peminat
                                </a>
                            </div>

                        </div>

                        <!-- Baris Tombol Aksi Bawah -->
                        <div class="pt-4 mt-3 border-t border-waris-surface-muted flex items-center justify-between gap-2">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('items.show', $item) }}" 
                                   class="px-3 py-1.5 bg-waris-surface-muted hover:bg-waris-border text-waris-text-secondary rounded-xl text-xs font-bold transition-colors">
                                    Lihat
                                </a>
                                <a href="{{ route('items.edit', $item) }}" 
                                   class="px-3 py-1.5 bg-waris-surface-muted hover:bg-waris-primary-soft hover:text-waris-primary text-waris-text-secondary rounded-xl text-xs font-bold transition-colors">
                                    Edit
                                </a>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('claims.incoming', ['item_id' => $item->id]) }}" 
                                   class="px-3 py-1.5 bg-waris-primary hover:bg-waris-primary-hover text-white rounded-xl text-xs font-bold transition-colors flex items-center space-x-1">
                                    <x-icon name="inbox" class="w-3.5 h-3.5" />
                                    <span>Peminat ({{ $item->claims->count() }})</span>
                                </a>

                                <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Seluruh data pengajuan terkait juga akan terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-1.5 rounded-xl text-waris-faint hover:text-waris-danger hover:bg-waris-danger-soft transition-colors cursor-pointer" 
                                            title="Hapus Barang">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $items->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-waris-surface rounded-3xl p-12 text-center border border-waris-border shadow-2xs space-y-4 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-waris-primary-soft text-waris-primary-muted flex items-center justify-center mx-auto border border-waris-primary-border">
                    <x-icon name="package" class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-waris-text">Belum Ada Barang yang Dipasang</h3>
                    <p class="text-xs text-waris-subtle mt-1 leading-relaxed">
                        Anda belum memiliki barang yang terpasang di waris.in. Punya buku, kalkulator, atau alat praktikum yang sudah tidak terpakai? Pasang sekarang!
                    </p>
                </div>
                <div>
                    <a href="{{ route('items.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-waris-accent hover:bg-waris-accent-hover text-white rounded-xl text-xs font-bold shadow-2xs">
                        <x-icon name="plus" class="w-4 h-4" />
                        <span>Pasang Barang Pertama</span>
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
