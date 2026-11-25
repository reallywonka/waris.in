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
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-waris-border">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-waris-subtle mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-waris-text font-bold">Pengajuan Masuk</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                    Dashboard Pengajuan Masuk
                </h1>
                <p class="text-xs sm:text-sm text-waris-subtle mt-1">
                    Kelola dan seleksi permohonan klaim atau barter dari sesama mahasiswa untuk barang yang Anda pasang.
                </p>
            </div>

            <div class="flex items-center space-x-2.5">
                <a href="{{ route('items.my') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-surface border border-waris-border hover:border-waris-primary-border text-waris-text-secondary hover:text-waris-primary rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <x-icon name="package" class="w-4 h-4 text-waris-primary-muted" />
                    <span>Barang Saya</span>
                </a>
                <a href="{{ route('items.create') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-accent hover:bg-waris-accent-hover text-white rounded-xl text-xs font-bold transition-colors shadow-2xs">
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
                   class="px-3.5 py-2 rounded-xl transition-all {{ !request()->filled('status') ? 'bg-waris-primary text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                    Semua ({{ $totalCount }})
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'pending' ? 'bg-waris-accent text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-accent-text' }}">
                    <span class="w-2 h-2 rounded-full bg-waris-accent-border"></span>
                    <span>Menunggu ({{ $pendingCount }})</span>
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'approved' ? 'bg-waris-primary-muted text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-primary' }}">
                    <span class="w-2 h-2 rounded-full bg-waris-primary-border"></span>
                    <span>Disetujui ({{ $approvedCount }})</span>
                </a>
                <a href="{{ route('claims.incoming', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}" 
                   class="px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 {{ request('status') === 'rejected' ? 'bg-waris-text text-white shadow-2xs' : 'bg-waris-surface border border-waris-border text-waris-muted hover:text-waris-text' }}">
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
                            class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
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
                    <div class="bg-waris-surface rounded-3xl border border-waris-border shadow-2xs p-5 sm:p-6 transition-all hover:border-waris-border-strong">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            
                            <!-- Kolom Kiri -->
                            <div class="space-y-4 flex-1">
                                
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-waris-surface-muted">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $claim->item->primary_image_url }}" 
                                             alt="{{ $claim->item->title }}"
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                             class="w-10 h-10 rounded-xl object-cover border border-waris-border shrink-0">
                                        <div>
                                            <a href="{{ route('items.show', $claim->item) }}" class="text-xs font-bold text-waris-text hover:text-waris-primary transition-colors line-clamp-1">
                                                {{ $claim->item->title }}
                                            </a>
                                            <div class="flex items-center space-x-2 text-[11px] text-waris-subtle mt-0.5">
                                                <span class="font-bold {{ $claim->item->mode === 'harga_pas' ? 'text-waris-accent-text' : ($claim->item->mode === 'barter' ? 'text-waris-barter-text' : 'text-waris-primary') }}">
                                                    {{ $claim->item->formatted_price }}
                                                </span>
                                                <span>&bull;</span>
                                                <span class="text-waris-faint">Status Barang: <strong class="{{ $claim->item->status === 'available' ? 'text-waris-primary-muted' : 'text-waris-text-secondary' }}">{{ $claim->item->status === 'available' ? 'Tersedia' : 'Terkunci' }}</strong></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge Pengajuan -->
                                    <div>
                                        @if ($claim->status === 'pending')
                                            <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border">
                                                <span class="w-2 h-2 rounded-full bg-waris-accent animate-pulse"></span>
                                                <span>Menunggu Persetujuan</span>
                                            </span>
                                        @elseif ($claim->status === 'approved')
                                            <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-waris-primary-soft text-waris-primary border border-waris-primary-border">
                                                <x-icon name="check" class="w-3.5 h-3.5 text-waris-primary-muted" />
                                                <span>Disetujui & Kontak Terbuka</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-bold bg-waris-surface-muted text-waris-subtle border border-waris-border">
                                                <span>Ditolak</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Info Profil Mahasiswa Pengaju -->
                                <div class="flex items-center justify-between gap-3 bg-waris-surface-hover p-3.5 rounded-2xl border border-waris-surface-muted">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $claim->claimant->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($claim->claimant->name).'&background=065F46&color=ffffff' }}" 
                                             alt="{{ $claim->claimant->name }}" 
                                             class="w-10 h-10 rounded-full object-cover border border-waris-primary/20 shrink-0">
                                        <div>
                                            <div class="flex items-center space-x-1.5">
                                                <span class="font-bold text-waris-text text-xs">{{ $claim->claimant->name }}</span>
                                                <x-icon name="user-check" class="w-3.5 h-3.5 text-waris-primary-muted" />
                                            </div>
                                            <span class="text-[11px] text-waris-subtle block">
                                                {{ $claim->claimant->faculty ?? 'Mahasiswa' }} &bull; Angkatan {{ $claim->claimant->batch ?? 'Aktif' }}
                                                @if ($claim->claimant->nim)
                                                    <span class="text-waris-faint">({{ $claim->claimant->nim }})</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right text-[11px] text-waris-faint shrink-0">
                                        <span class="block">Mengajukan</span>
                                        <span class="font-semibold text-waris-muted">{{ $claim->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Isi Pesan Pengaju -->
                                <div class="space-y-1">
                                    <span class="text-[11px] font-bold text-waris-faint uppercase tracking-wider block">Pesan Singkat Pengaju:</span>
                                    <div class="text-xs text-waris-text-secondary bg-waris-surface p-3.5 rounded-2xl border border-waris-border leading-relaxed italic">
                                        "{{ $claim->message }}"
                                    </div>
                                </div>

                                <!-- Rincian Tawaran Barter -->
                                @if ($claim->offered_item_desc)
                                    <div class="p-3.5 bg-waris-barter-soft/80 rounded-2xl border border-waris-barter-border space-y-1">
                                        <div class="flex items-center space-x-1.5 text-waris-barter-text text-[11px] font-bold uppercase tracking-wider">
                                            <x-icon name="repeat" class="w-3.5 h-3.5" />
                                            <span>Barang yang Ditawarkan untuk Barter:</span>
                                        </div>
                                        <p class="text-xs font-bold text-waris-text mt-1">
                                            {{ $claim->offered_item_desc }}
                                        </p>
                                    </div>
                                @endif

                            </div>

                            <!-- Kolom Kanan: Aksi Keputusan / Kontak Terbuka -->
                            <div class="lg:w-72 shrink-0 flex flex-col justify-between pt-2 lg:pt-0 lg:border-l lg:border-waris-surface-muted lg:ps-6 space-y-4">
                                
                                @if ($claim->status === 'pending')
                                    <div class="space-y-2">
                                        <span class="text-[11px] font-bold text-waris-faint uppercase tracking-wider block">Tindakan Pemilik:</span>
                                        
                                        @if ($claim->item->status === 'available')
                                            <button type="button"
                                                    @click="openApproveModal({
                                                        id: {{ $claim->id }},
                                                        itemTitle: '{{ addslashes($claim->item->title) }}',
                                                        claimantName: '{{ addslashes($claim->claimant->name) }}',
                                                        actionUrl: '{{ route('claims.approve', $claim) }}'
                                                    })"
                                                    class="w-full py-3 px-4 bg-waris-primary hover:bg-waris-primary-hover text-white font-bold text-xs rounded-xl shadow-2xs hover:shadow-xs transition-colors flex items-center justify-center space-x-1.5 cursor-pointer">
                                                <x-icon name="check" class="w-4 h-4" />
                                                <span>Setujui Pengajuan</span>
                                            </button>

                                            <!-- Tombol Tolak -->
                                            <form method="POST" 
                                                  action="{{ route('claims.reject', $claim) }}" 
                                                  data-confirm="Tolak permohonan dari {{ addslashes($claim->claimant->name) }} untuk barang ini?"
                                                  data-confirm-title="Tolak Pengajuan Peminat?"
                                                  data-confirm-button="Ya, Tolak Pengajuan"
                                                  data-confirm-color="rose"
                                                  data-confirm-icon="x"
                                                  data-confirm-note="Peminat akan menerima pemberitahuan bahwa pengajuannya ditolak. Tindakan ini tidak dapat dibatalkan.">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full py-2.5 px-4 bg-waris-surface border border-waris-border hover:bg-waris-danger-soft hover:text-waris-danger-text hover:border-waris-danger-border text-waris-muted font-bold text-xs rounded-xl transition-colors cursor-pointer">
                                                    Tolak Pengajuan
                                                </button>
                                            </form>
                                            
                                            <p class="text-[10px] text-waris-faint leading-tight">
                                                *Menyetujui akan otomatis mengunci barang & menolak pengajuan pending lainnya.
                                            </p>
                                        @else
                                            <div class="p-3 bg-waris-surface-hover border border-waris-border rounded-xl text-center text-xs text-waris-subtle">
                                                Barang sudah terkunci untuk peminat lain.
                                            </div>
                                        @endif
                                    </div>

                                @elseif ($claim->status === 'approved')
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $claim->contact_info);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                        $waUrl = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode("Halo {$claim->claimant->name}, saya telah menyetujui pengajuan Anda untuk barang '{$claim->item->title}' di waris.in. Kapan bisa ketemuan COD di kampus?");
                                    @endphp

                                    <div class="p-4 bg-waris-primary-soft rounded-2xl border border-waris-primary-border space-y-3">
                                        <div class="flex items-center space-x-1.5 text-waris-primary">
                                            <x-icon name="shield" class="w-4 h-4 text-waris-primary-muted" />
                                            <span class="text-xs font-bold">Kontak Mahasiswa Terbuka</span>
                                        </div>

                                        <div class="bg-waris-surface p-2.5 rounded-xl border border-waris-primary-border">
                                            <span class="text-[10px] text-waris-faint uppercase font-bold block">Nomor WhatsApp / HP:</span>
                                            <span class="text-xs font-mono font-bold text-waris-text block mt-0.5">{{ $claim->contact_info }}</span>
                                        </div>

                                        <a href="{{ $waUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="w-full py-2.5 px-3 bg-waris-primary hover:bg-waris-primary-hover text-white font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center space-x-1.5">
                                            <span>Chat via WhatsApp</span>
                                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                                        </a>

                                        <div class="text-[11px] text-waris-primary leading-tight">
                                            Titik COD: <strong>{{ $claim->item->meetup_location ?? 'Sekitar Kampus' }}</strong>
                                        </div>
                                    </div>

                                @else
                                    <div class="p-3.5 bg-waris-surface-hover rounded-2xl border border-waris-border text-center space-y-1">
                                        <span class="text-xs font-bold text-waris-subtle block">Pengajuan Ditolak</span>
                                        <p class="text-[11px] text-waris-faint leading-snug">
                                            Pengajuan ini tidak dilanjutkan untuk transaksi barang ini.
                                        </p>
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
                    <x-icon name="inbox" class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-waris-text">Belum Ada Pengajuan Masuk</h3>
                    <p class="text-xs text-waris-subtle mt-1 leading-relaxed">
                        @if (request()->filled('status'))
                            Tidak ditemukan pengajuan dengan status "{{ request('status') }}".
                        @else
                            Saat ini belum ada mahasiswa yang mengajukan klaim atau barter untuk barang yang Anda pasang.
                        @endif
                    </p>
                </div>
                @if (request()->filled('status') || request()->filled('item_id'))
                    <a href="{{ route('claims.incoming') }}" class="inline-block text-xs font-bold text-waris-primary underline">
                        Reset Filter
                    </a>
                @endif
            </div>
        @endif

        <!-- 4. Modal Konfirmasi Persetujuan Klaim -->
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
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-waris-text/60 backdrop-blur-xs transition-opacity"
                 @click="approveModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="approveModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-3xl bg-waris-surface text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-waris-surface-muted p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary flex items-center justify-center shrink-0 border border-waris-primary-border">
                            <x-icon name="check" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-waris-text" id="approve-modal-title">
                                Konfirmasi Persetujuan Klaim
                            </h3>
                            <p class="text-xs text-waris-subtle mt-0.5">
                                Serahkan barang kepada <span class="font-bold text-waris-text" x-text="selectedClaim ? selectedClaim.claimantName : ''"></span>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 bg-waris-accent-soft rounded-2xl border border-waris-accent-border text-xs text-waris-accent-text space-y-2">
                        <span class="font-bold block flex items-center space-x-1">
                            <x-icon name="shield" class="w-4 h-4 text-waris-accent shrink-0" />
                            <span>Konsekuensi Persetujuan Transaksi:</span>
                        </span>
                        <ul class="list-disc list-inside space-y-1 text-[11px] leading-relaxed">
                            <li>Status barang akan otomatis diubah menjadi <strong>Terkunci (Locked)</strong>.</li>
                            <li>Seluruh pengajuan pending lainnya untuk barang ini akan <strong>otomatis ditolak</strong> oleh sistem.</li>
                            <li>Nomor kontak WhatsApp mahasiswa peminat akan langsung terbuka untuk Anda.</li>
                        </ul>
                    </div>

                    <div class="pt-2 flex items-center justify-end space-x-2">
                        <button type="button" 
                                @click="approveModalOpen = false" 
                                class="px-4 py-2.5 rounded-xl border border-waris-border-strong text-xs font-bold text-waris-text-secondary hover:bg-waris-surface-muted transition-colors cursor-pointer">
                            Batal
                        </button>
                        
                        <form :action="selectedClaim ? selectedClaim.actionUrl : '#'" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-waris-primary hover:bg-waris-primary-hover active:bg-waris-primary-active text-white text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                                Ya, Setujui Sekarang
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
