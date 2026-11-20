@props(['item'])

@php
    $isOwner = auth()->check() && auth()->id() === $item->user_id;
    $isAvailable = $item->status === 'available';
@endphp

<div class="bg-white rounded-3xl border border-gray-100/90 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col justify-between group">
    
    <!-- 1. Bagian Atas: Gambar & Badge -->
    <div class="relative w-full h-52 bg-gray-100 overflow-hidden">
        <!-- Foto Barang -->
        <img src="{{ $item->primary_image_url }}" 
             alt="{{ $item->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ !$isAvailable ? 'grayscale-[40%]' : '' }}">

        <!-- Overlay Gelap Tipis -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

        <!-- Badge Mode (Kiri Atas) -->
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 items-center">
            @if ($item->mode === 'harga_pas')
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-500/95 text-white shadow-xs backdrop-blur-xs">
                    🏷️ Rp {{ number_format($item->price, 0, ',', '.') }}
                </span>
            @elseif ($item->mode === 'gratis')
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-700/95 text-white shadow-xs backdrop-blur-xs">
                    🎁 Gratis
                </span>
            @elseif ($item->mode === 'barter')
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-teal-700/95 text-white shadow-xs backdrop-blur-xs">
                    🔄 Barter
                </span>
            @endif

            @if ($isOwner)
                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-950/80 text-emerald-200 backdrop-blur-xs border border-emerald-400/30">
                    Milik Saya
                </span>
            @endif
        </div>

        <!-- Badge Ketersediaan (Kanan Atas) -->
        <div class="absolute top-3 right-3">
            @if ($isAvailable)
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-semibold bg-white/95 text-emerald-800 shadow-xs border border-emerald-100 backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1.5 animate-pulse"></span>
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-semibold bg-gray-900/80 text-gray-200 shadow-xs backdrop-blur-xs border border-white/20">
                    🔒 Terkunci
                </span>
            @endif
        </div>

        <!-- Pita Permintaan Barter (Jika Mode Barter) -->
        @if ($item->mode === 'barter' && $item->barter_request)
            <div class="absolute bottom-2.5 left-2.5 right-2.5 bg-black/70 backdrop-blur-xs text-white text-[11px] font-medium py-1 px-2.5 rounded-lg truncate flex items-center space-x-1.5 border border-white/10">
                <span class="text-teal-300 font-bold shrink-0">⇄ Tukar:</span>
                <span class="truncate">{{ $item->barter_request }}</span>
            </div>
        @endif
    </div>

    <!-- 2. Bagian Konten Kartu -->
    <div class="p-5 flex-grow flex flex-col justify-between">
        <div>
            <!-- Kategori & Waktu Tayang -->
            <div class="flex items-center justify-between text-[11px] text-gray-400 font-medium mb-1.5">
                <span class="text-emerald-800 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">
                    {{ $item->category }}
                </span>
                <span>⏱️ {{ $item->created_at->diffForHumans() }}</span>
            </div>

            <!-- Judul Barang -->
            <h3 class="font-bold text-gray-900 text-sm line-clamp-1 group-hover:text-emerald-800 transition-colors" title="{{ $item->title }}">
                {{ $item->title }}
            </h3>

            <!-- Tag Kondisi & Lokasi Kampus -->
            <div class="mt-2.5 flex flex-wrap gap-1.5 text-[11px]">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-700">
                    <span class="text-emerald-600 font-bold me-1">✓</span> {{ $item->condition }}
                </span>
                @if ($item->user->faculty)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50/60 text-emerald-900 font-medium border border-emerald-100/50">
                        🏛️ {{ $item->user->faculty }}
                    </span>
                @endif
            </div>
        </div>

        <!-- 3. Bagian Bawah: Profil Pemilik & Tombol Aksi -->
        <div class="mt-5 pt-3.5 border-t border-gray-100 flex items-center justify-between">
            <!-- Profil Pemilik -->
            <div class="flex items-center space-x-2.5 truncate pr-2">
                <img class="w-7 h-7 rounded-full object-cover border border-emerald-700/20 shrink-0" 
                     src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=144d37&color=ffffff' }}" 
                     alt="{{ $item->user->name }}">
                <div class="truncate">
                    <div class="text-xs font-bold text-gray-800 truncate leading-tight">
                        {{ $item->user->name }}
                    </div>
                    <div class="text-[10px] text-gray-400 truncate">
                        {{ $item->user->faculty ?? 'Mahasiswa Aktif' }}
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-gray-100 hover:bg-emerald-50 text-emerald-900 text-xs font-bold rounded-xl border border-gray-200 transition-colors">
                        <span>Kelola</span>
                        <span>✏️</span>
                    </a>
                @else
                    @if ($isAvailable)
                        <a href="{{ Route::has('items.show') ? route('items.show', $item) : '#' }}" 
                           class="inline-flex items-center space-x-1 px-3 py-1.5 bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                            <span>Lihat Detail</span>
                            <span>&rarr;</span>
                        </a>
                    @else
                        <button disabled 
                                class="inline-flex items-center space-x-1 px-3 py-1.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl cursor-not-allowed">
                            <span>Terkunci</span>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
