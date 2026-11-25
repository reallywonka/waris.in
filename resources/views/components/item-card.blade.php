@props(['item'])

@php
    $isOwner = auth()->check() && auth()->id() === $item->user_id;
    $isAvailable = $item->status === 'available';
@endphp

<div class="bg-waris-surface rounded-2xl border border-waris-border hover:border-waris-primary/40 shadow-2xs hover:shadow-sm transition-all duration-200 overflow-hidden flex flex-col justify-between group">
    
    <!-- 1. Bagian Atas: Gambar & Badge -->
    <div class="relative w-full h-48 bg-waris-surface-muted overflow-hidden">
        <!-- Foto Barang -->
        <img src="{{ $item->primary_image_url }}" 
             alt="{{ $item->title }}"
             loading="lazy"
             referrerpolicy="no-referrer"
             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300 {{ !$isAvailable ? 'grayscale-[40%]' : '' }}">

        <!-- Badge Mode (Kiri Atas) -->
        <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5 items-center">
            @if ($item->mode === 'harga_pas')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-waris-accent text-white shadow-2xs">
                    <x-icon name="tag" class="w-3 h-3 text-white" />
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </span>
            @elseif ($item->mode === 'gratis')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-waris-primary text-white shadow-2xs">
                    <x-icon name="gift" class="w-3 h-3 text-white" />
                    <span>Gratis</span>
                </span>
            @elseif ($item->mode === 'barter')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-waris-barter text-white shadow-2xs">
                    <x-icon name="repeat" class="w-3 h-3 text-white" />
                    <span>Barter</span>
                </span>
            @endif

            @if ($isOwner)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-waris-text/85 text-waris-primary-border border border-waris-primary-border/30">
                    Milik Saya
                </span>
            @endif
        </div>

        <!-- Status Ketersediaan (Kanan Atas) -->
        <div class="absolute top-2.5 right-2.5">
            @if ($isAvailable)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-waris-surface/95 text-waris-primary shadow-2xs border border-waris-primary-border">
                    <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-muted me-1.5"></span>
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md text-xs font-medium bg-waris-text/90 text-waris-surface-muted border border-white/20">
                    <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                    <span>Terkunci</span>
                </span>
            @endif
        </div>

        <!-- Pita Permintaan Barter (Jika Mode Barter) -->
        @if ($item->mode === 'barter' && $item->barter_request)
            <div class="absolute bottom-2 left-2 right-2 bg-waris-text/80 backdrop-blur-xs text-white text-xs font-medium py-1 px-2 rounded-md truncate flex items-center space-x-1.5">
                <span class="text-waris-barter-border font-semibold shrink-0">Tukar:</span>
                <span class="truncate text-waris-surface-muted">{{ $item->barter_request }}</span>
            </div>
        @endif
    </div>

    <!-- 2. Bagian Konten Kartu: Judul, Kategori, Metadata -->
    <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
        <div>
            <!-- Kategori & Waktu Tayang -->
            <div class="flex items-center justify-between text-xs text-waris-subtle mb-1.5">
                <span class="font-medium text-waris-primary bg-waris-primary-soft px-2 py-0.5 rounded-md border border-waris-primary-border/70">
                    {{ $item->category }}
                </span>
                <span class="flex items-center space-x-1 text-waris-faint">
                    <x-icon name="clock" class="w-3 h-3" />
                    <span>{{ $item->created_at->diffForHumans() }}</span>
                </span>
            </div>

            <!-- Judul Barang -->
            <h3 class="font-bold text-waris-text text-sm line-clamp-2 leading-snug group-hover:text-waris-primary transition-colors" title="{{ $item->title }}">
                <a href="{{ route('items.show', $item) }}">
                    {{ $item->title }}
                </a>
            </h3>

            <!-- Tag Kondisi & Fakultas -->
            <div class="mt-2 flex flex-wrap gap-1.5 text-xs">
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-waris-surface-muted text-waris-text-secondary font-medium">
                    <x-icon name="check" class="w-3 h-3 text-waris-primary-muted" />
                    <span>{{ $item->condition }}</span>
                </span>
                @if ($item->user->faculty)
                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-waris-primary-soft/70 text-waris-primary font-medium border border-waris-primary-border/60">
                        <x-icon name="building" class="w-3 h-3 text-waris-primary" />
                        <span>{{ $item->user->faculty }}</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- 3. Bagian Bawah: Profil Pemilik & Tombol Aksi -->
        <div class="pt-3 border-t border-waris-surface-muted flex items-center justify-between">
            <!-- Profil Pemilik -->
            <div class="flex items-center space-x-2 truncate pr-2">
                <img class="w-6 h-6 rounded-full object-cover border border-waris-primary/20 shrink-0" 
                     src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=065f46&color=ffffff' }}" 
                     alt="{{ $item->user->name }}">
                <div class="truncate">
                    <div class="text-xs font-semibold text-waris-text truncate leading-tight">
                        {{ $item->user->name }}
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ route('items.my') }}" 
                       class="inline-flex items-center space-x-1 px-2.5 py-1 bg-waris-surface-muted hover:bg-waris-primary-soft text-waris-primary text-xs font-semibold rounded-lg border border-waris-border transition-colors">
                        <x-icon name="settings" class="w-3 h-3 text-waris-primary" />
                        <span>Kelola</span>
                        <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                    </a>
                @else
                    @if ($isAvailable)
                        <a href="{{ route('items.show', $item) }}" 
                           class="inline-flex items-center space-x-1 px-3 py-1 bg-waris-primary hover:bg-waris-primary-hover text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors">
                            <span>Detail</span>
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    @else
                        <span class="inline-flex items-center space-x-1 px-2.5 py-1 bg-waris-surface-muted text-waris-faint text-xs font-medium rounded-lg">
                            <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                            <span>Terkunci</span>
                        </span>
                    @endif
                @endif
            </div>
        </div>

    </div>

</div>
