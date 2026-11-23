<x-app-layout>
    <div x-data="{ 
            selectedClaim: null, 
            approveModalOpen: false,
            openApproveModal(claim) {
                this.selectedClaim = claim;
                this.approveModalOpen = true;
            }
         }" 
         class="space-y-8 pb-16">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-gray-800 font-bold">Pengajuan Masuk</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Dashboard Pengajuan Masuk
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Kelola dan seleksi permohonan klaim atau barter dari sesama mahasiswa untuk barang yang Anda pasang.
                </p>
            </div>

            <div class="flex items-center space-x-2.5">
                <a href="{{ route('items.my') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:border-emerald-300 text-gray-700 hover:text-emerald-900 rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <x-icon name="package" class="w-4 h-4 text-emerald-700" />
                    <span>Barang Saya</span>
                </a>
                <a href="{{ route('items.create') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <x-icon name="plus" class="w-4 h-4" />
                    <span>Pasang Barang Baru</span>
                </a>
            </div>
        </div>

        <!-- 2. Filter Tab & Dropdown Barang -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <!-- Tab Status -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-1 sm:pb-0 scrollbar-none text-xs font-bold">
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => ''])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all {{ !request()->filled('status') ? 'bg-emerald-800 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-emerald-900' }}">
                    Semua ({{ $totalCount }})
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'pending' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-amber-800' }}">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>Menunggu ({{ $pendingCount }})</span>
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'approved' ? 'bg-emerald-700 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-emerald-900' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Disetujui ({{ $approvedCount }})</span>
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'rejected' ? 'bg-gray-800 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-600 hover:text-gray-900' }}">
                    <span>Ditolak ({{ $rejectedCount }})</span>
                </a>
            </div>

            <!-- Filter Dropdown Berdasarkan Barang -->
            @if ($myItems->count() > 0)
                <form method="GET" action="{{ route('claims.incoming') }}" class="sm:w-64">
                    @if (request()->filled('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <select name="item_id" 
                            onchange="this.form.submit()" 
                            class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs bg-white">
                        <option value="">Semua Barang Anda</option>
                        @foreach ($myItems as $myItem)
                            <option value="{{ $myItem->id }}" {{ request('item_id') == $myItem->id ? 'selected' : '' }}>
                                {{ Str::limit($myItem->title, 28) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>

        <!-- 3. Daftar Kartu Pengajuan -->
        @if ($claims->count() > 0)
            <div class="space-y-4">
                @foreach ($claims as $claim)
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-2xs p-5 sm:p-6 transition-all hover:border-gray-300">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            
                            <!-- Kolom Kiri: Rincian Barang & Pengaju -->
                            <div class="space-y-4 flex-1">
                                
                                <!-- Baris Atas: Info Barang Terkait & Status Pengajuan -->
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $claim->item->primary_image_url }}" 
                                             alt="{{ $claim->item->title }}"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                             class="w-10 h-10 rounded-xl object-cover border border-gray-200 shrink-0">
                                        <div>
                                            <a href="{{ route('items.show', $claim->item) }}" class="text-xs font-black text-gray-900 hover:text-emerald-800 transition-colors line-clamp-1">
                                                {{ $claim->item->title }}
                                            </a>
                                            <div class="flex items-center space-x-2 text-[11px] text-gray-500 mt-0.5">
                                                <span class="font-bold {{ $claim->item->mode === 'harga_pas' ? 'text-amber-800' : ($claim->item->mode === 'barter' ? 'text-teal-800' : 'text-emerald-800') }}">
                                                    {{ $claim->item->formatted_price }}
                                                </span>
                                                <span>&bull;</span>
                                                <span class="text-gray-400">Status Barang: <strong class="{{ $claim->item->status === 'available' ? 'text-emerald-700' : 'text-gray-700' }}">{{ $claim->item->status === 'available' ? 'Tersedia' : 'Terkunci' }}</strong></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge Pengajuan -->
                                    <div>
                                        @if ($claim->status === 'pending')
                                            <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span>Menunggu Persetujuan</span>
                                            </span>
                                        @elseif ($claim->status === 'approved')
                                            <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <x-icon name="check" class="w-3.5 h-3.5 text-emerald-700" />
                                                <span>Disetujui & Kontak Terbuka</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                                <span>Ditolak</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Info Profil Mahasiswa Pengaju -->
                                <div class="flex items-center justify-between gap-3 bg-gray-50/70 p-3.5 rounded-2xl border border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $claim->claimant->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($claim->claimant->name).'&background=144d37&color=ffffff' }}" 
                                             alt="{{ $claim->claimant->name }}" 
                                             class="w-10 h-10 rounded-full object-cover border border-emerald-700/20 shrink-0">
                                        <div>
                                            <div class="flex items-center space-x-1.5">
                                                <span class="font-bold text-gray-900 text-xs">{{ $claim->claimant->name }}</span>
                                                <x-icon name="user-check" class="w-3.5 h-3.5 text-emerald-700" />
                                            </div>
                                            <span class="text-[11px] text-gray-500 block">
                                                {{ $claim->claimant->faculty ?? 'Mahasiswa' }} &bull; Angkatan {{ $claim->claimant->batch ?? 'Aktif' }}
                                                @if ($claim->claimant->nim)
                                                    <span class="text-gray-400">({{ $claim->claimant->nim }})</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right text-[11px] text-gray-400 shrink-0">
                                        <span class="block">Mengajukan</span>
                                        <span class="font-semibold text-gray-600">{{ $claim->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Isi Pesan Pengaju -->
                                <div class="space-y-1">
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Pesan Singkat Pengaju:</span>
                                    <div class="text-xs text-gray-700 bg-white p-3.5 rounded-2xl border border-gray-200 leading-relaxed italic">
                                        "{{ $claim->message }}"
                                    </div>
                                </div>

                                <!-- Rincian Tawaran Barter (Jika Ada) -->
                                @if ($claim->offered_item_desc)
                                    <div class="p-3.5 bg-teal-50/80 rounded-2xl border border-teal-200 space-y-1">
                                        <div class="flex items-center space-x-1.5 text-teal-800 text-[11px] font-bold uppercase tracking-wider">
                                            <x-icon name="repeat" class="w-3.5 h-3.5" />
                                            <span>Barang yang Ditawarkan untuk Barter:</span>
                                        </div>
                                        <p class="text-xs font-bold text-teal-950 mt-1">
                                            {{ $claim->offered_item_desc }}
                                        </p>
                                    </div>
                                @endif

                            </div>

                            <!-- Kolom Kanan: Aksi Keputusan / Kontak Terbuka -->
                            <div class="lg:w-72 shrink-0 flex flex-col justify-between pt-2 lg:pt-0 lg:border-l lg:border-gray-100 lg:ps-6 space-y-4">
                                
                                @if ($claim->status === 'pending')
                                    <!-- Aksi Jika Masih Menunggu -->
                                    <div class="space-y-2">
                                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Tindakan Pemilik:</span>
                                        
                                        @if ($claim->item->status === 'available')
                                            <!-- Tombol Buka Modal Setujui -->
                                            <button type="button"
                                                    @click="openApproveModal({
                                                        id: {{ $claim->id }},
                                                        itemTitle: '{{ addslashes($claim->item->title) }}',
                                                        claimantName: '{{ addslashes($claim->claimant->name) }}',
                                                        actionUrl: '{{ route('claims.approve', $claim) }}'
                                                    })"
                                                    class="w-full py-3 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-2xs hover:shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                                                <x-icon name="check" class="w-4 h-4" />
                                                <span>Setujui Pengajuan</span>
                                            </button>

                                            <!-- Tombol Tolak -->
                                            <form method="POST" action="{{ route('claims.reject', $claim) }}" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?');">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full py-2.5 px-4 bg-white border border-gray-200 hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 text-gray-600 font-bold text-xs rounded-xl transition-colors">
                                                    Tolak Pengajuan
                                                </button>
                                            </form>
                                            
                                            <p class="text-[10px] text-gray-400 leading-tight">
                                                *Menyetujui akan otomatis mengunci barang & menolak pengajuan pending lainnya.
                                            </p>
                                        @else
                                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl text-center text-xs text-gray-500">
                                                Barang sudah terkunci untuk peminat lain.
                                            </div>
                                        @endif
                                    </div>

                                @elseif ($claim->status === 'approved')
                                    <!-- Jika Sudah Disetujui: Buka Kontak WhatsApp Langsung -->
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $claim->contact_info);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                        $waUrl = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode("Halo {$claim->claimant->name}, saya telah menyetujui pengajuan Anda untuk barang '{$claim->item->title}' di waris.in. Kapan bisa ketemuan COD di kampus?");
                                    @endphp

                                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 space-y-3">
                                        <div class="flex items-center space-x-1.5 text-emerald-900">
                                            <x-icon name="shield" class="w-4 h-4 text-emerald-700" />
                                            <span class="text-xs font-black">Kontak Mahasiswa Terbuka</span>
                                        </div>

                                        <div class="bg-white p-2.5 rounded-xl border border-emerald-100">
                                            <span class="text-[10px] text-gray-400 uppercase font-bold block">Nomor WhatsApp / HP:</span>
                                            <span class="text-xs font-mono font-bold text-gray-900 block mt-0.5">{{ $claim->contact_info }}</span>
                                        </div>

                                        <a href="{{ $waUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="w-full py-2.5 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center space-x-1.5">
                                            <span>Chat via WhatsApp</span>
                                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                                        </a>

                                        <div class="text-[10px] text-emerald-800 leading-tight">
                                            📍 Titik COD: <strong>{{ $claim->item->meetup_location ?? 'Sekitar Kampus' }}</strong>
                                        </div>
                                    </div>

                                @else
                                    <!-- Jika Ditolak -->
                                    <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-200 text-center space-y-1">
                                        <span class="text-xs font-bold text-gray-500 block">Pengajuan Ditolak</span>
                                        <p class="text-[11px] text-gray-400 leading-snug">
                                            Pengajuan ini tidak dilanjutkan untuk transaksi barang ini.
                                        </p>
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
                    <x-icon name="inbox" class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Belum Ada Pengajuan Masuk</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        @if (request()->filled('status'))
                            Tidak ditemukan pengajuan dengan status "{{ request('status') }}".
                        @else
                            Saat ini belum ada mahasiswa yang mengajukan klaim atau barter untuk barang yang Anda pasang.
                        @endif
                    </p>
                </div>
                @if (request()->filled('status') || request()->filled('item_id'))
                    <a href="{{ route('claims.incoming') }}" class="inline-block text-xs font-bold text-emerald-800 underline">
                        Reset Filter
                    </a>
                @endif
            </div>
        @endif

        <!-- 4. Modal Pop-up Konfirmasi Persetujuan Klaim (Atomic Engine Confirmation) -->
        <div x-show="approveModalOpen" 
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="approve-modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="approveModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:exit="ease-in duration-200"
                 x-transition:exit-start="opacity-100"
                 x-transition:exit-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
                 @click="approveModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="approveModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit="ease-in duration-200"
                     x-transition:exit-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 border border-emerald-200">
                            <x-icon name="check" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900" id="approve-modal-title">
                                Konfirmasi Persetujuan Klaim
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Serahkan barang kepada <span class="font-bold text-gray-800" x-text="selectedClaim ? selectedClaim.claimantName : ''"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Warning Box Efek Otomatis -->
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 text-xs text-amber-900 space-y-2">
                        <span class="font-bold block flex items-center space-x-1">
                            <x-icon name="shield" class="w-4 h-4 text-amber-800 shrink-0" />
                            <span>Konsekuensi Persetujuan Transaksi:</span>
                        </span>
                        <ul class="list-disc list-inside space-y-1 text-[11px] leading-relaxed text-amber-950">
                            <li>Status barang akan otomatis diubah menjadi <strong>Terkunci (Locked)</strong>.</li>
                            <li>Seluruh pengajuan pending lainnya untuk barang ini akan <strong>otomatis ditolak</strong> oleh sistem.</li>
                            <li>Nomor kontak WhatsApp mahasiswa peminat akan langsung terbuka untuk Anda.</li>
                        </ul>
                    </div>

                    <!-- Tombol Aksi Modal -->
                    <div class="pt-2 flex items-center justify-end space-x-2">
                        <button type="button" 
                                @click="approveModalOpen = false" 
                                class="px-4 py-2.5 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors">
                            Batal
                        </button>
                        
                        <form :action="selectedClaim ? selectedClaim.actionUrl : '#'" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-emerald-800 hover:bg-emerald-900 active:bg-emerald-950 text-white text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                                Ya, Setujui Sekarang
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
