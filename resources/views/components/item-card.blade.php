@props(['item'])

@php
    $isOwner = auth()->check() && auth()->id() === $item->user_id;
    $isAvailable = $item->status === 'available';
@endphp

<div class="bg-white rounded-2xl border border-slate-200/90 hover:border-emerald-600/40 shadow-2xs hover:shadow-sm transition-all duration-200 overflow-hidden flex flex-col justify-between group">
    
    <!-- 1. Bagian Atas: Gambar & Badge -->
    <div class="relative w-full h-48 bg-slate-100 overflow-hidden">
        <!-- Foto Barang -->
        <img src="{{ $item->primary_image_url }}" 
             alt="{{ $item->title }}"
             loading="lazy"
             referrerpolicy="no-referrer"
             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ !$isAvailable ? 'grayscale-[40%]' : '' }}">

        <!-- Badge Mode (Kiri Atas) -->
        <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5 items-center">
            @if ($item->mode === 'harga_pas')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-amber-600 text-white shadow-2xs">
                    <x-icon name="tag" class="w-3 h-3 text-white" />
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </span>
            @elseif ($item->mode === 'gratis')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-emerald-800 text-white shadow-2xs">
                    <x-icon name="gift" class="w-3 h-3 text-white" />
                    <span>Gratis</span>
                </span>
            @elseif ($item->mode === 'barter')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-teal-700 text-white shadow-2xs">
                    <x-icon name="repeat" class="w-3 h-3 text-white" />
                    <span>Barter</span>
                </span>
            @endif

            @if ($isOwner)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-900/80 text-emerald-300 border border-emerald-400/30">
                    Milik Saya
                </span>
            @endif
        </div>

        <!-- Badge Ketersediaan (Kanan Atas) -->
        <div class="absolute top-2.5 right-2.5">
            @if ($isAvailable)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-white/95 text-emerald-800 shadow-2xs border border-emerald-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1.5"></span>
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md text-xs font-medium bg-slate-900/90 text-slate-200 border border-white/20">
                    <x-icon name="lock" class="w-3 h-3 text-slate-300" />
                    <span>Terkunci</span>
                </span>
            @endif
        </div>

        <!-- Pita Permintaan Barter (Jika Mode Barter) -->
        @if ($item->mode === 'barter' && $item->barter_request)
            <div class="absolute bottom-2 left-2 right-2 bg-black/75 backdrop-blur-xs text-white text-xs font-medium py-1 px-2 rounded-md truncate flex items-center space-x-1.5">
                <span class="text-teal-300 font-semibold shrink-0">Tukar:</span>
                <span class="truncate text-slate-100">{{ $item->barter_request }}</span>
            </div>
        @endif
    </div>

    <!-- 2. Bagian Konten Kartu -->
    <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
        <div>
            <!-- Kategori & Waktu Tayang -->
            <div class="flex items-center justify-between text-xs text-slate-500 mb-1.5">
                <span class="font-medium text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/70">
                    {{ $item->category }}
                </span>
                <span class="flex items-center space-x-1 text-slate-400">
                    <x-icon name="clock" class="w-3 h-3" />
                    <span>{{ $item->created_at->diffForHumans() }}</span>
                </span>
            </div>

            <!-- Judul Barang -->
            <h3 class="font-bold text-gray-900 text-sm line-clamp-2 leading-snug group-hover:text-emerald-800 transition-colors" title="{{ $item->title }}">
                <a href="{{ route('items.show', $item) }}">
                    {{ $item->title }}
                </a>
            </h3>

            <!-- Tag Kondisi & Fakultas -->
            <div class="mt-2 flex flex-wrap gap-1.5 text-xs">
                <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-medium">
                    <x-icon name="check" class="w-3 h-3 text-emerald-700" />
                    <span>{{ $item->condition }}</span>
                </span>
                @if ($item->user->faculty)
                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md bg-emerald-50/70 text-emerald-900 font-medium border border-emerald-100/80">
                        <x-icon name="building" class="w-3 h-3 text-emerald-800" />
                        <span>{{ $item->user->faculty }}</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- 3. Bagian Bawah: Profil Pemilik & Tombol Aksi -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <!-- Profil Pemilik -->
            <div class="flex items-center space-x-2 truncate pr-2">
                <img class="w-6 h-6 rounded-full object-cover border border-emerald-800/20 shrink-0" 
                     src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=065f46&color=ffffff' }}" 
                     alt="{{ $item->user->name }}">
                <div class="truncate">
                    <div class="text-xs font-semibold text-gray-800 truncate leading-tight">
                        {{ $item->user->name }}
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi (Bebas dari Dead Link '#') -->
            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ route('items.my') }}" 
                       class="inline-flex items-center space-x-1 px-2.5 py-1 bg-slate-100 hover:bg-emerald-50 text-emerald-900 text-xs font-semibold rounded-lg border border-slate-200 transition-colors">
                        <x-icon name="settings" class="w-3 h-3 text-emerald-800" />
                        <span>Kelola</span>
                    </a>
                @else
                    @if ($isAvailable)
                        <a href="{{ route('items.show', $item) }}" 
                           class="inline-flex items-center space-x-1 px-3 py-1 bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors">
                            <span>Detail</span>
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    @else
                        <span class="inline-flex items-center space-x-1 px-2.5 py-1 bg-slate-100 text-slate-400 text-xs font-medium rounded-lg">
                            <x-icon name="lock" class="w-3 h-3 text-slate-400" />
                            <span>Terkunci</span>
                        </span>
                    @endif
                @endif
            </div>
        </div>

    </div>

</div>
