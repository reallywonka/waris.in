@props(['item'])

@php
    $isOwner = auth()->check() && auth()->id() === $item->user_id;
    $isAvailable = $item->status === 'available';
@endphp

<div class="bg-white rounded-2xl border border-gray-200/80 hover:border-gray-300 hover:shadow-md transition-all duration-200 p-3 sm:p-3.5 flex flex-col justify-between group">
    
    <!-- 1. Bagian Atas: Gambar, Badge Mode & Heart Icon (Sesuai Referensi Daily Discover) -->
    <div class="relative w-full aspect-square bg-[#f8f8f6] rounded-xl overflow-hidden flex items-center justify-center p-3">
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
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-600 text-white shadow-2xs">
                    <x-icon name="tag" class="w-3 h-3 text-white" />
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </span>
            @elseif ($item->mode === 'gratis')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-800 text-white shadow-2xs">
                    <x-icon name="gift" class="w-3 h-3 text-white" />
                    <span>Gratis</span>
                </span>
            @elseif ($item->mode === 'barter')
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-700 text-white shadow-2xs">
                    <x-icon name="repeat" class="w-3 h-3 text-white" />
                    <span>Barter</span>
                </span>
            @endif

            @if ($isOwner)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-900 text-emerald-300 shadow-2xs">
                    Milik Saya
                </span>
            @endif
        </div>

        <!-- Ikon Wishlist / Heart (Kanan Atas seperti di Referensi Shopee) -->
        <div class="absolute top-2.5 right-2.5">
            <span class="w-7 h-7 rounded-full bg-white/90 backdrop-blur-xs text-gray-400 hover:text-rose-500 shadow-2xs flex items-center justify-center transition-colors cursor-pointer"
                  title="Simpan ke favorit">
                <x-icon name="heart" class="w-3.5 h-3.5" />
            </span>
        </div>

        <!-- Pita Permintaan Barter (Jika Mode Barter) -->
        @if ($item->mode === 'barter' && $item->barter_request)
            <div class="absolute bottom-2 left-2 right-2 bg-gray-900/85 backdrop-blur-xs text-white text-[10px] font-medium py-1 px-2 rounded-lg truncate flex items-center space-x-1">
                <span class="text-teal-300 font-bold shrink-0">Tukar:</span>
                <span class="truncate text-gray-100">{{ $item->barter_request }}</span>
            </div>
        @endif
    </div>

    <!-- 2. Bagian Konten Kartu: Judul, Harga, Metadata -->
    <div class="pt-3 flex-grow flex flex-col justify-between space-y-2.5">
        <div>
            <!-- Kategori & Waktu Tayang -->
            <div class="flex items-center justify-between text-[11px] text-gray-500 mb-1">
                <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md">
                    {{ $item->category }}
                </span>
                <span class="flex items-center space-x-1 text-gray-400 text-[10px]">
                    <x-icon name="clock" class="w-3 h-3" />
                    <span>{{ $item->created_at->diffForHumans() }}</span>
                </span>
            </div>

            <!-- Judul Barang -->
            <h3 class="font-bold text-gray-900 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-emerald-800 transition-colors" title="{{ $item->title }}">
                <a href="{{ route('items.show', $item) }}">
                    {{ $item->title }}
                </a>
            </h3>

            <!-- Harga Tampilan Utama (Gaya Shopee: Bold, Jelas, & Kontras) -->
            <div class="mt-1.5 flex items-baseline space-x-1.5">
                <span class="text-sm sm:text-base font-black text-gray-900">
                    {{ $item->formatted_price }}
                </span>
                <span class="text-[10px] text-gray-400 font-medium">
                    &bull; {{ $item->condition }}
                </span>
            </div>

            <!-- Info Fakultas / Kampus -->
            @if ($item->user->faculty)
                <div class="mt-1 text-[10px] text-gray-500 flex items-center space-x-1 truncate">
                    <x-icon name="building" class="w-3 h-3 text-gray-400 shrink-0" />
                    <span class="truncate">{{ $item->user->faculty }}</span>
                </div>
            @endif
        </div>

        <!-- 3. Bagian Bawah: Profil Pemilik & Tautan Aksi (Gaya "View product >") -->
        <div class="pt-2.5 border-t border-gray-100 flex items-center justify-between">
            <!-- Profil Pemilik -->
            <div class="flex items-center space-x-2 truncate pr-2">
                <img class="w-6 h-6 rounded-full object-cover border border-emerald-800/20 shrink-0" 
                     src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=065f46&color=ffffff' }}" 
                     alt="{{ $item->user->name }}">
                <span class="text-[10px] font-semibold text-gray-700 truncate leading-tight">
                    {{ $item->user->name }}
                </span>
            </div>

            <!-- Tombol / Tautan Aksi -->
            <div class="shrink-0">
                @if ($isOwner)
                    <a href="{{ route('items.my') }}" 
                       class="inline-flex items-center space-x-1 text-xs font-bold text-amber-700 hover:text-amber-900 transition-colors">
                        <span>Kelola</span>
                        <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                    </a>
                @else
                    @if ($isAvailable)
                        <a href="{{ route('items.show', $item) }}" 
                           class="inline-flex items-center space-x-1 text-xs font-bold text-emerald-800 hover:text-emerald-950 transition-colors group/link">
                            <span>Detail barang</span>
                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-emerald-700 group-hover/link:translate-x-0.5 transition-transform" />
                        </a>
                    @else
                        <span class="inline-flex items-center space-x-1 text-[10px] font-bold text-gray-400">
                            <x-icon name="lock" class="w-3 h-3 text-gray-400" />
                            <span>Terkunci</span>
                        </span>
                    @endif
                @endif
            </div>
        </div>

    </div>

</div>