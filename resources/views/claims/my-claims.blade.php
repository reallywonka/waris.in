<x-app-layout>
    <div class="space-y-8 pb-16">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-gray-800 font-bold">Pengajuan Saya</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Dashboard Pengajuan Saya
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Pantau status permohonan klaim dan tawaran barter barang yang Anda kirimkan ke sesama mahasiswa.
                </p>
            </div>

            <a href="{{ route('items.index') }}" 
               class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-bold transition-colors shadow-2xs self-start md:self-auto">
                <x-icon name="search" class="w-4 h-4" />
                <span>Jelajahi Katalog Kampus</span>
            </a>
        </div>

        <!-- 2. Filter Tab Status -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-none text-xs font-bold">
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => ''])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all {{ !request()->filled('status') ? 'bg-emerald-800 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-emerald-900' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'pending' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-amber-800' }}">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span>Menunggu ({{ $pendingCount }})</span>
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'approved' ? 'bg-emerald-700 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-emerald-900' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>Disetujui ({{ $approvedCount }})</span>
            </a>
            <a href="{{ route('claims.my', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'rejected' ? 'bg-gray-800 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-gray-900' }}">
                <span>Ditolak ({{ $rejectedCount }})</span>
            </a>
        </div>

        <!-- 3. Daftar Kartu Pengajuan -->
        @if ($claims->count() > 0)
            <div class="space-y-5">
                @foreach ($claims as $claim)
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-2xs p-5 sm:p-6 transition-all hover:border-gray-300">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            
                            <!-- Sisi Kiri: Rincian Barang & Pengajuan -->
                            <div class="space-y-4 flex-1">
                                
                                <!-- Baris Atas: Info Barang -->
                                <div class="flex items-start space-x-4 pb-3 border-b border-gray-100">
                                    <img src="{{ $claim->item->primary_image_url }}" 
                                         alt="{{ $claim->item->title }}"
                                         onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                         class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl object-cover border border-gray-200 shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-lg text-[10px] font-black {{ $claim->item->mode === 'harga_pas' ? 'bg-amber-50 text-amber-800 border border-amber-200' : ($claim->item->mode === 'barter' ? 'bg-teal-50 text-teal-800 border border-teal-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200') }}">
                                                {{ $claim->item->formatted_price }}
                                            </span>
                                            <span class="text-xs text-gray-400">&bull;</span>
                                            <span class="text-xs text-gray-500">{{ $claim->item->category }}</span>
                                        </div>
                                        <a href="{{ route('items.show', $claim->item) }}" class="text-sm sm:text-base font-black text-gray-900 hover:text-emerald-800 transition-colors block truncate">
                                            {{ $claim->item->title }}
                                        </a>
                                        <div class="text-[11px] text-gray-500 mt-0.5">
                                            Pemilik: <span class="font-bold text-gray-800">{{ $claim->item->user->name }}</span> ({{ $claim->item->user->faculty ?? 'Mahasiswa' }})
                                        </div>
                                    </div>
                                </div>

                                <!-- Data yang Dikirimkan oleh Pemohon -->
                                <div class="space-y-2 bg-gray-50/70 p-4 rounded-2xl border border-gray-100 text-xs">
                                    <div class="flex items-center justify-between text-gray-400 text-[10px] uppercase font-bold tracking-wider">
                                        <span>Rincian Pengajuan Anda:</span>
                                        <span>Dikirim {{ $claim->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <p class="text-gray-700 italic leading-relaxed">
                                        "{{ $claim->message }}"
                                    </p>

                                    @if ($claim->offered_item_desc)
                                        <div class="pt-2 border-t border-gray-200/60">
                                            <span class="text-[10px] font-bold text-teal-800 uppercase tracking-wider block">Tawaran Barter Anda:</span>
                                            <span class="font-bold text-teal-950 block mt-0.5">{{ $claim->offered_item_desc }}</span>
                                        </div>
                                    @endif

                                    <div class="pt-1 text-[11px] text-gray-400">
                                        Kontak Anda: <span class="font-mono font-medium text-gray-600">{{ $claim->contact_info }}</span>
                                    </div>
                                </div>

                            </div>

                            <!-- Sisi Kanan: Status & Kontak Unlocked -->
                            <div class="lg:w-80 shrink-0 pt-2 lg:pt-0 lg:border-l lg:border-gray-100 lg:ps-6">
                                
                                @if ($claim->status === 'approved')
                                    <!-- DISAHKAN: Kontak Pemilik & Lokasi COD Terbuka -->
                                    @php
                                        // Gunakan kontak dari contact_info barang jika ada, fallback ke phone user
                                        $ownerContact = $claim->item->contact_info ?? $claim->item->user->phone ?? '08123456789';
                                        $cleanOwnerPhone = preg_replace('/[^0-9]/', '', $ownerContact);
                                        if (str_starts_with($cleanOwnerPhone, '0')) {
                                            $cleanOwnerPhone = '62' . substr($cleanOwnerPhone, 1);
                                        }
                                        $waMessage = "Halo Kak {$claim->item->user->name}, pengajuan saya untuk '{$claim->item->title}' di waris.in telah disetujui. Mau koordinasi waktu dan titik temu COD di kampus...";
                                        $waUrl = 'https://wa.me/' . $cleanOwnerPhone . '?text=' . urlencode($waMessage);
                                    @endphp

                                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 space-y-3">
                                        <div class="flex items-center space-x-1.5 text-emerald-900">
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-ping"></span>
                                            <span class="text-xs font-black">🎉 Pengajuan Anda Disetujui!</span>
                                        </div>

                                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                                            Pemilik telah memilih Anda! Silakan langsung hubungi pemilik melalui WhatsApp untuk koordinasi COD.
                                        </p>

                                        <div class="bg-white p-3 rounded-xl border border-emerald-100 space-y-1.5">
                                            <div>
                                                <span class="text-[10px] text-gray-400 uppercase font-bold block">Kontak WhatsApp Pemilik:</span>
                                                <span class="text-xs font-mono font-bold text-gray-900 block mt-0.5">{{ $ownerContact }}</span>
                                            </div>
                                            <div class="pt-1 border-t border-gray-100 text-[11px]">
                                                <span class="text-gray-400 block font-semibold">Titik Temu Kampus:</span>
                                                <span class="text-gray-800 font-bold block">{{ $claim->item->meetup_location ?? 'Sekitar Kampus Utama' }}</span>
                                            </div>
                                            @if ($claim->item->time_handover)
                                                <div class="text-[11px]">
                                                    <span class="text-gray-400 block font-semibold">Waktu Serah Terima:</span>
                                                    <span class="text-gray-800 font-bold block">{{ $claim->item->time_handover }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ $waUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="w-full py-2.5 px-3 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center space-x-1.5">
                                            <span>Chat Pemilik via WhatsApp</span>
                                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                                        </a>
                                    </div>

                                @elseif ($claim->status === 'pending')
                                    <!-- MENUNGGU PERSETUJUAN -->
                                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 space-y-2.5">
                                        <div class="flex items-center space-x-1.5 text-amber-900">
                                            <x-icon name="clock" class="w-4 h-4 text-amber-700" />
                                            <span class="text-xs font-black">Sedang Menunggu Konfirmasi</span>
                                        </div>
                                        <p class="text-[11px] text-amber-800 leading-relaxed">
                                            Pemilik barang sedang meninjau permohonan Anda. Nomor kontak pemilik akan otomatis terbuka di sini begitu pengajuan disetujui.
                                        </p>
                                        <div class="pt-1">
                                            <a href="{{ route('items.show', $claim->item) }}" class="inline-block text-xs font-bold text-amber-900 underline">
                                                Lihat Rincian Barang &rarr;
                                            </a>
                                        </div>
                                    </div>

                                @else
                                    <!-- DITOLAK -->
                                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 space-y-2">
                                        <div class="flex items-center space-x-1.5 text-gray-700">
                                            <x-icon name="lock" class="w-4 h-4 text-gray-400" />
                                            <span class="text-xs font-black">Belum Terpilih</span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 leading-relaxed">
                                            Barang ini telah dialokasikan kepada mahasiswa lain yang lebih membutuhkan. Jangan berkecil hati ya!
                                        </p>
                                        <a href="{{ route('items.index', ['category' => $claim->item->category]) }}" class="inline-block text-xs font-bold text-emerald-800 underline pt-1">
                                            Cari barang lain di kategori ini &rarr;
                                        </a>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pt-4">
                    {{ $claims->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-2xs space-y-4 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto border border-emerald-100">
                    <x-icon name="clock" class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Belum Ada Pengajuan</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        @if (request()->filled('status'))
                            Tidak ada pengajuan dengan status "{{ request('status') }}".
                        @else
                            Anda belum pernah mengajukan permohonan klaim atau barter barang. Temukan barang kuliah yang Anda butuhkan di katalog sekarang!
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('items.index') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-2xs">
                        <span>Jelajahi Katalog Sekarang</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
