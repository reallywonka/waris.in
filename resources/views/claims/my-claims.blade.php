<x-app-layout>
    <div class="space-y-8 pb-16">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-waris-border">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-waris-subtle mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-waris-text font-bold">Pengajuan Saya</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                    Dashboard Pengajuan Saya
                </h1>
                <p class="text-xs sm:text-sm text-waris-subtle mt-1">
                    Pantau status permohonan klaim dan tawaran barter barang yang Anda kirimkan ke sesama mahasiswa.
                </p>
            </div>

            <a href="{{ route('items.index') }}" 
               class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-primary hover:bg-waris-primary-hover text-white rounded-xl text-xs font-bold transition-colors shadow-2xs self-start md:self-auto">
                <x-icon name="search" class="w-4 h-4" />
                <span>Jelajahi Katalog Kampus</span>
            </a>
        </div>

        <!-- 2. Filter Tab Status -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-none text-xs font-bold">
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => ''])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all {{ !request()->filled('status') ? 'bg-waris-primary text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'pending' ? 'bg-waris-accent text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-accent-text' }}">
                <span class="w-2 h-2 rounded-full bg-waris-accent-border"></span>
                <span>Menunggu ({{ $pendingCount }})</span>
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'approved' ? 'bg-waris-primary-muted text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                <span class="w-2 h-2 rounded-full bg-waris-primary-border"></span>
                <span>Disetujui ({{ $approvedCount }})</span>
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'rejected' ? 'bg-waris-text text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-text' }}">
                <span>Ditolak ({{ $rejectedCount }})</span>
            </a>
        </div>

        <!-- 3. Daftar Kartu Pengajuan -->
        @if ($claims->count() > 0)
            <div class="space-y-5">
                @foreach ($claims as $claim)
                    <div class="bg-waris-surface rounded-3xl border border-waris-border shadow-2xs p-5 sm:p-6 transition-all hover:border-waris-border-strong">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            
                            <!-- Sisi Kiri: Rincian Barang & Pengajuan -->
                            <div class="space-y-4 flex-1">
                                
                                <div class="flex items-start space-x-4 pb-3 border-b border-waris-surface-muted">
                                    <img src="{{ $claim->item->primary_image_url }}" 
                                         alt="{{ $claim->item->title }}"
                                         onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                         class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover border border-waris-border shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold {{ $claim->item->mode === 'harga_pas' ? 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border' : ($claim->item->mode === 'barter' ? 'bg-waris-barter-soft text-waris-barter-text border border-waris-barter-border' : 'bg-waris-primary-soft text-waris-primary border border-waris-primary-border') }}">
                                                {{ $claim->item->formatted_price }}
                                            </span>
                                            <span class="text-xs text-waris-faint">&bull;</span>
                                            <span class="text-xs text-waris-subtle">{{ $claim->item->category }}</span>
                                        </div>
                                        <a href="{{ route('items.show', $claim->item) }}" class="text-sm sm:text-base font-bold text-waris-text hover:text-waris-primary transition-colors block truncate">
                                            {{ $claim->item->title }}
                                        </a>
                                        <div class="text-[11px] text-waris-subtle mt-0.5">
                                            Pemilik: <span class="font-bold text-waris-text">{{ $claim->item->user->name }}</span> ({{ $claim->item->user->faculty ?? 'Mahasiswa' }})
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2 bg-waris-surface-hover p-4 rounded-2xl border border-waris-surface-muted text-xs">
                                    <div class="flex items-center justify-between text-waris-faint text-[10px] uppercase font-bold tracking-wider">
                                        <span>Rincian Pengajuan Anda:</span>
                                        <span>Dikirim {{ $claim->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <p class="text-waris-text-secondary italic leading-relaxed">
                                        "{{ $claim->message }}"
                                    </p>

                                    @if ($claim->offered_item_desc)
                                        <div class="pt-2 border-t border-waris-border/60">
                                            <span class="text-[10px] font-bold text-waris-barter-text uppercase tracking-wider block">Tawaran Barter Anda:</span>
                                            <span class="font-bold text-waris-text block mt-0.5">{{ $claim->offered_item_desc }}</span>
                                        </div>
                                    @endif

                                    <div class="pt-1 text-[11px] text-waris-faint">
                                        Kontak Anda: <span class="font-mono font-medium text-waris-muted">{{ $claim->contact_info }}</span>
                                    </div>
                                </div>

                            </div>

                            <!-- Sisi Kanan: Status & Kontak Unlocked -->
                            <div class="lg:w-80 shrink-0 pt-2 lg:pt-0 lg:border-l lg:border-waris-surface-muted lg:ps-6">
                                
                                @if ($claim->status === 'approved')
                                    @php
                                        $ownerContact = $claim->item->contact_info ?? $claim->item->user->phone ?? '08123456789';
                                        $cleanOwnerPhone = preg_replace('/[^0-9]/', '', $ownerContact);
                                        if (str_starts_with($cleanOwnerPhone, '0')) {
                                            $cleanOwnerPhone = '62' . substr($cleanOwnerPhone, 1);
                                        }
                                        $waMessage = "Halo Kak {$claim->item->user->name}, pengajuan saya untuk '{$claim->item->title}' di waris.in telah disetujui. Mau koordinasi waktu dan titik temu COD di kampus...";
                                        $waUrl = 'https://wa.me/' . $cleanOwnerPhone . '?text=' . urlencode($waMessage);
                                    @endphp

                                    <div class="p-4 bg-waris-primary-soft rounded-2xl border border-waris-primary-border space-y-3">
                                        <div class="flex items-center space-x-1.5 text-waris-primary">
                                            <span class="w-2.5 h-2.5 rounded-full bg-waris-primary-muted animate-ping"></span>
                                            <span class="text-xs font-bold">Pengajuan Anda Disetujui!</span>
                                        </div>

                                        <p class="text-[11px] text-waris-primary leading-relaxed">
                                            Pemilik telah memilih Anda! Silakan langsung hubungi pemilik melalui WhatsApp untuk koordinasi COD.
                                        </p>

                                        <div class="bg-waris-surface p-3 rounded-xl border border-waris-primary-border space-y-1.5">
                                            <div>
                                                <span class="text-[10px] text-waris-faint uppercase font-bold block">Kontak WhatsApp Pemilik:</span>
                                                <span class="text-xs font-mono font-bold text-waris-text block mt-0.5">{{ $ownerContact }}</span>
                                            </div>
                                            <div class="pt-1 border-t border-waris-surface-muted text-[11px]">
                                                <span class="text-waris-faint block font-semibold">Titik Temu Kampus:</span>
                                                <span class="text-waris-text font-bold block">{{ $claim->item->meetup_location ?? 'Sekitar Kampus Utama' }}</span>
                                            </div>
                                            @if ($claim->item->time_handover)
                                                <div class="text-[11px]">
                                                    <span class="text-waris-faint block font-semibold">Waktu Serah Terima:</span>
                                                    <span class="text-waris-text font-bold block">{{ $claim->item->time_handover }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ $waUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="w-full py-2.5 px-3 bg-waris-primary hover:bg-waris-primary-hover text-white font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center space-x-1.5">
                                            <span>Chat Pemilik via WhatsApp</span>
                                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                                        </a>
                                    </div>

                                @elseif ($claim->status === 'pending')
                                    <div class="p-4 bg-waris-accent-soft rounded-2xl border border-waris-accent-border space-y-2.5">
                                        <div class="flex items-center space-x-1.5 text-waris-accent-text">
                                            <x-icon name="clock" class="w-4 h-4 text-waris-accent" />
                                            <span class="text-xs font-bold">Sedang Menunggu Konfirmasi</span>
                                        </div>
                                        <p class="text-[11px] text-waris-accent-text leading-relaxed">
                                            Pemilik barang sedang meninjau permohonan Anda. Nomor kontak pemilik akan otomatis terbuka di sini begitu pengajuan disetujui.
                                        </p>
                                        <div class="pt-1">
                                            <a href="{{ route('items.show', $claim->item) }}" class="inline-block text-xs font-bold text-waris-accent-text underline">
                                                Lihat Rincian Barang &rarr;
                                            </a>
                                        </div>
                                    </div>

                                @else
                                    <div class="p-4 bg-waris-surface-hover rounded-2xl border border-waris-border space-y-2">
                                        <div class="flex items-center space-x-1.5 text-waris-text-secondary">
                                            <x-icon name="lock" class="w-4 h-4 text-waris-faint" />
                                            <span class="text-xs font-bold">Belum Terpilih</span>
                                        </div>
                                        <p class="text-[11px] text-waris-subtle leading-relaxed">
                                            Barang ini telah dialokasikan kepada mahasiswa lain yang lebih membutuhkan. Jangan berkecil hati ya!
                                        </p>
                                        <a href="{{ route('items.index', ['category' => $claim->item->category]) }}" class="inline-block text-xs font-bold text-waris-primary underline pt-1">
                                            Cari barang lain di kategori ini &rarr;
                                        </a>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                @endforeach

                <div class="pt-4">
                    {{ $claims->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-waris-surface rounded-3xl p-12 text-center border border-waris-border shadow-2xs space-y-4 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-waris-primary-soft text-waris-primary-muted flex items-center justify-center mx-auto border border-waris-primary-border">
                    <x-icon name="clock" class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-waris-text">Belum Ada Pengajuan</h3>
                    <p class="text-xs text-waris-subtle mt-1 leading-relaxed">
                        @if (request()->filled('status'))
                            Tidak ada pengajuan dengan status "{{ request('status') }}".
                        @else
                            Anda belum pernah mengajukan permohonan klaim atau barter barang. Temukan barang kuliah yang Anda butuhkan di katalog sekarang!
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('items.index') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-waris-primary hover:bg-waris-primary-hover text-white rounded-xl text-xs font-bold shadow-2xs">
                        <span>Jelajahi Katalog Sekarang</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
