@props(['item'])

@php
    $isOwner = auth()->check() && auth()->id() === $item->user_id;
    $isAvailable = $item->status === 'available';
@endphp

<div class="bg-white rounded-3xl border border-gray-200 hover:border-emerald-600/40 shadow-2xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col justify-between group">
    
    <!-- 1. Bagian Atas: Gambar & Badge Interaktif -->
    <div class="relative w-full h-52 bg-gray-100 overflow-hidden">
        <!-- Foto Barang -->
        <img src="{{ $item->primary_image_url }}" 
             alt="{{ $item->title }}"
             loading="lazy"
             referrerpolicy="no-referrer"
             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ !$isAvailable ? 'grayscale-[40%]' : '' }}">

        <!-- Overlay Gelap Tipis Gradasi Bawah -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

        <!-- Badge Mode (Kiri Atas) -->
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 items-center">
            @if ($item->mode === 'harga_pas')
                <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-xl text-xs font-black bg-amber-500 text-white shadow-2xs">
                    <x-icon name="tag" class="w-3 h-3 text-white" />
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </span>
            @elseif ($item->mode === 'gratis')
                <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-xl text-xs font-black bg-emerald-700 text-white shadow-2xs">
                    <x-icon name="gift" class="w-3 h-3 text-white" />
                    <span>Gratis</span>
                </span>
            @elseif ($item->mode === 'barter')
                <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-xl text-xs font-black bg-teal-700 text-white shadow-2xs">
                    <x-icon name="repeat" class="w-3 h-3 text-white" />
                    <span>Barter</span>
                </span>
            @endif

            @if ($isOwner)
                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-gray-900/90 text-emerald-300 border border-emerald-400/30">
                    Milik Saya
                </span>
            @endif
        </div>

        <!-- Badge Ketersediaan (Kanan Atas) -->
        <div class="absolute top-3 right-3">
            @if ($isAvailable)
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-bold bg-white text-emerald-800 shadow-2xs border border-emerald-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1.5 animate-pulse"></span>
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-gray-900/90 text-gray-200 border border-white/20">
                    <x-icon name="lock" class="w-3 h-3 text-gray-300" />
                    <span>Terkunci</span>
                </span>
            @endif
        </div>

        <!-- Pita Permintaan Barter (Jika Mode Barter) -->
        @if ($item->mode === 'barter' && $item->barter_request)
            <div class="absolute bottom-2.5 left-2.5 right-2.5 bg-black/80 text-white text-[11px] font-medium py-1 px-2.5 rounded-lg truncate flex items-center space-x-1.5 border border-white/10">
                <span class="text-teal-300 font-bold shrink-0 flex items-center space-x-1">
                    <x-icon name="repeat" class="w-3 h-3 text-teal-300" />
                    <span>Cari:</span>
                </span>
                <span class="truncate">{{ $item->barter_request }}</span>
            </div>
        @endif
    </div>

    <!-- 2. Bagian Konten Kartu -->
    <div class="p-5 flex-grow flex flex-col justify-between">
        <div>
            <!-- Kategori & Waktu Tayang -->
            <div class="flex items-center justify-between text-[11px] text-gray-400 font-medium mb-1.5">
                <span class="text-emerald-800 font-bold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/70">
                    {{ $item->category }}
                </span>
                <span class="flex items-center space-x-1">
                    <x-icon name="clock" class="w-3 h-3 text-gray-400" />
                    <span>{{ $item->created_at->diffForHumans() }}</span>
                </span>
            </div>

            <!-- Judul Barang -->
            <h3 class="font-bold text-gray-900 text-sm line-clamp-2 leading-snug group-hover:text-emerald-800 transition-colors mt-1" title="{{ $item->title }}">
                <a href="{{ route('items.show', $item) }}">
                    {{ $item->title }}
                </a>
            </h3>

            <!-- Tag Kondisi & Lokasi Kampus -->
            <div class="mt-2.5 flex flex-wrap gap-1.5 text-[11px]">
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 font-medium">
                    <x-icon name="check" class="w-3 h-3 text-emerald-700" />
                    <span>{{ $item->condition }}</span>
                </span>
                @if ($item->user->faculty)
                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-900 font-medium border border-emerald-100/80">
                        <x-icon name="building" class="w-3 h-3 text-emerald-800" />
                        <span>{{ $item->user->faculty }}</span>
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
                        {{ $item->user->faculty ?? 'Mahasiswa' }}
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-gray-100 hover:bg-emerald-50 text-emerald-900 text-xs font-bold rounded-xl border border-gray-200 transition-colors">
                        <x-icon name="settings" class="w-3 h-3 text-emerald-800" />
                        <span>Kelola</span>
                    </a>
                @else
                    @if ($isAvailable)
                        <a href="{{ route('items.show', $item) }}" 
                           class="inline-flex items-center space-x-1 px-3.5 py-1.5 bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-bold rounded-xl shadow-2xs transition-colors">
                            <span>Detail</span>
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    @else
                        <button disabled 
                                class="inline-flex items-center space-x-1 px-3 py-1.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl cursor-not-allowed">
                            <x-icon name="lock" class="w-3 h-3 text-gray-400" />
                            <span>Terkunci</span>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
