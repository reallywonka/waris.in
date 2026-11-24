<x-app-layout>
    <div x-data="{
            activeTab: '{{ request('tab', $tab ?? 'items') }}',
            deleteModalOpen: false,
            itemToDelete: null,
            suspendModalOpen: false,
            userToSuspend: null,
            openDeleteModal(item) {
                this.itemToDelete = item;
                this.deleteModalOpen = true;
            },
            openSuspendModal(user) {
                this.userToSuspend = user;
                this.suspendModalOpen = true;
            }
         }" 
         class="space-y-8 pb-16">

        <!-- 1. Header Halaman Moderasi Admin -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-waris-border">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-waris-subtle mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-waris-accent-text font-bold">Portal Moderasi Admin</span>
                </nav>
                <div class="flex items-center space-x-2.5">
                    <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                        Portal Moderasi Kampus
                    </h1>
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border shadow-2xs">
                        <x-icon name="shield" class="w-3.5 h-3.5 text-waris-accent" />
                        <span>Admin Privileged</span>
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-waris-subtle mt-1">
                    Pengawasan ketertiban listing barang perkuliahan dan manajemen penangguhan akun sivitas akademika waris.in.
                </p>
            </div>

            <div class="flex items-center space-x-2.5">
                <a href="{{ route('items.index') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-waris-surface border border-waris-border hover:border-waris-primary-border text-waris-text-secondary hover:text-waris-primary rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98]">
                    <x-icon name="search" class="w-4 h-4 text-waris-primary-muted" />
                    <span>Lihat Katalog Publik</span>
                </a>
            </div>
        </div>

        <!-- 2. Ringkasan Metrik Platform -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Mahasiswa Terdaftar</span>
                    <span class="text-2xl font-bold text-waris-text block mt-1">{{ $totalStudents }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary flex items-center justify-center border border-waris-primary-border">
                    <x-icon name="users" class="w-5 h-5 text-waris-primary-muted" />
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Total Listing Barang</span>
                    <span class="text-2xl font-bold text-waris-primary block mt-1">{{ $totalItems }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary flex items-center justify-center border border-waris-primary-border">
                    <x-icon name="package" class="w-5 h-5 text-waris-primary-muted" />
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Sirkulasi Aktif</span>
                    <span class="text-2xl font-bold text-waris-primary-muted block mt-1">{{ $activeItems }}</span>
                    <span class="text-[10px] text-waris-faint block mt-0.5">{{ $lockedItems }} Terkunci / Deal</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-waris-primary-soft text-waris-primary-muted flex items-center justify-center border border-waris-primary-border">
                    <span class="w-3 h-3 rounded-full bg-waris-primary-muted animate-pulse"></span>
                </div>
            </div>

            <div class="bg-waris-surface p-5 rounded-3xl border border-waris-border shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-waris-faint uppercase tracking-wider block">Akun Ditangguhkan</span>
                    <span class="text-2xl font-bold {{ $suspendedStudents > 0 ? 'text-waris-danger' : 'text-waris-text' }} block mt-1">{{ $suspendedStudents }}</span>
                    <span class="text-[10px] text-waris-faint block mt-0.5">Pelanggaran Komunitas</span>
                </div>
                <div class="w-10 h-10 rounded-2xl {{ $suspendedStudents > 0 ? 'bg-waris-danger-soft text-waris-danger border-waris-danger-border' : 'bg-waris-surface-hover text-waris-subtle border-waris-border' }} flex items-center justify-center border">
                    <x-icon name="alert-triangle" class="w-5 h-5" />
                </div>
            </div>
        </div>

        <!-- 3. Tab Navigasi Moderasi (Barang vs Mahasiswa) -->
        <div class="flex items-center space-x-3 border-b border-waris-border pb-3">
            <button type="button" 
                    @click="activeTab = 'items'" 
                    class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer active:scale-[0.98]"
                    :class="activeTab === 'items' 
                        ? 'bg-waris-primary text-white shadow-2xs' 
                        : 'bg-waris-surface text-waris-muted hover:text-waris-primary border border-waris-border hover:border-waris-primary-border'">
                <x-icon name="package" class="w-4 h-4" />
                <span>Moderasi Listing Barang (FR-10)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold"
                      :class="activeTab === 'items' ? 'bg-waris-primary-hover text-waris-primary-border' : 'bg-waris-surface-muted text-waris-muted'">
                    {{ $items->total() }}
                </span>
            </button>

            <button type="button" 
                    @click="activeTab = 'users'" 
                    class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 cursor-pointer active:scale-[0.98]"
                    :class="activeTab === 'users' 
                        ? 'bg-waris-accent text-white shadow-2xs' 
                        : 'bg-waris-surface text-waris-muted hover:text-waris-accent-text border border-waris-border hover:border-waris-accent-border'">
                <x-icon name="users" class="w-4 h-4" />
                <span>Kelola Mahasiswa & Suspend (FR-11)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold"
                      :class="activeTab === 'users' ? 'bg-waris-accent-hover text-waris-accent-soft' : 'bg-waris-surface-muted text-waris-muted'">
                    {{ $users->total() }}
                </span>
            </button>
        </div>

        <!-- ================= TAB 1: MODERASI LISTING BARANG (FR-10) ================= -->
        <div x-show="activeTab === 'items'" class="space-y-5">
            
            <form method="GET" action="{{ route('admin.dashboard') }}" class="bg-waris-surface p-4 sm:p-5 rounded-3xl border border-waris-border shadow-2xs grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="tab" value="items">

                <div class="sm:col-span-6">
                    <input type="text" 
                           name="item_search" 
                           value="{{ request('item_search') }}" 
                           placeholder="Cari judul barang, deskripsi, atau nama pemilik..." 
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2.5 px-3 bg-waris-surface-hover text-waris-text shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <select name="item_status" 
                            class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2.5 px-3 bg-waris-surface text-waris-text shadow-2xs">
                        <option value="">Semua Status Barang</option>
                        <option value="available" {{ request('item_status') === 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="locked" {{ request('item_status') === 'locked' ? 'selected' : '' }}>Terkunci (Deal)</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-center space-x-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-waris-primary hover:bg-waris-primary-hover text-white rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98] cursor-pointer">
                        Filter Listing
                    </button>
                    @if (request()->hasAny(['item_search', 'item_status', 'item_mode']))
                        <a href="{{ route('admin.dashboard', ['tab' => 'items']) }}" 
                           class="py-2.5 px-3 bg-waris-surface-muted hover:bg-waris-border text-waris-text-secondary rounded-xl text-xs font-bold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabel Listing Barang -->
            <div class="bg-waris-surface rounded-3xl border border-waris-border shadow-2xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-waris-text-secondary">
                        <thead class="bg-waris-surface-hover text-[11px] uppercase font-bold text-waris-faint border-b border-waris-border">
                            <tr>
                                <th class="py-3.5 px-4">Barang</th>
                                <th class="py-3.5 px-4">Pemilik (Mahasiswa)</th>
                                <th class="py-3.5 px-4">Format Transaksi</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4">Dipasang</th>
                                <th class="py-3.5 px-4 text-right">Tindakan Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-waris-surface-muted">
                            @forelse ($items as $item)
                                <tr class="hover:bg-waris-surface-hover transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $item->primary_image_url }}" 
                                                 alt="{{ $item->title }}" 
                                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                                 class="w-12 h-12 rounded-xl object-cover border border-waris-border shrink-0">
                                            <div class="min-w-0">
                                                <a href="{{ route('items.show', $item) }}" target="_blank" class="font-bold text-waris-text hover:text-waris-primary transition-colors line-clamp-1">
                                                    {{ $item->title }}
                                                </a>
                                                <span class="text-[10px] text-waris-faint block mt-0.5">
                                                    {{ $item->category }} &bull; {{ $item->condition }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=065F46&color=ffffff' }}" 
                                                 alt="{{ $item->user->name }}" 
                                                 class="w-7 h-7 rounded-full object-cover border border-waris-primary/20 shrink-0">
                                            <div>
                                                <span class="font-bold text-waris-text block truncate max-w-32">{{ $item->user->name }}</span>
                                                <span class="text-[10px] text-waris-faint block truncate max-w-32">{{ $item->user->faculty ?? 'Mahasiswa' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold {{ $item->mode === 'harga_pas' ? 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border' : ($item->mode === 'barter' ? 'bg-waris-barter-soft text-waris-barter-text border border-waris-barter-border' : 'bg-waris-primary-soft text-waris-primary border border-waris-primary-border') }}">
                                            {{ $item->formatted_price }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4">
                                        @if ($item->status === 'available')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-waris-primary-soft text-waris-primary border border-waris-primary-border">
                                                <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-muted animate-pulse"></span>
                                                <span>Tersedia</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-waris-surface-muted text-waris-muted border border-waris-border">
                                                <x-icon name="lock" class="w-3 h-3 text-waris-faint" />
                                                <span>Terkunci</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4 text-waris-subtle text-[11px]">
                                        {{ $item->created_at->format('d M Y') }}
                                        <span class="text-waris-faint block text-[10px]">{{ $item->created_at->diffForHumans() }}</span>
                                    </td>

                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end space-x-1.5">
                                            <a href="{{ route('items.show', $item) }}" 
                                               target="_blank" 
                                               class="p-2 rounded-xl bg-waris-surface-muted hover:bg-waris-primary-soft hover:text-waris-primary text-waris-muted transition-colors" 
                                               title="Buka Halaman Barang">
                                                <x-icon name="link" class="w-3.5 h-3.5" />
                                            </a>

                                            <button type="button" 
                                                    @click="openDeleteModal({
                                                        id: {{ $item->id }},
                                                        title: '{{ addslashes($item->title) }}',
                                                        owner: '{{ addslashes($item->user->name) }}',
                                                        deleteUrl: '{{ route('admin.items.destroy', $item) }}'
                                                    })"
                                                    class="inline-flex items-center space-x-1 px-3 py-1.5 bg-waris-danger-soft hover:bg-waris-danger-border/40 text-waris-danger-text border border-waris-danger-border rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer"
                                                    title="Hapus Listing Pelanggaran">
                                                <x-icon name="trash" class="w-3.5 h-3.5 text-waris-danger" />
                                                <span>Hapus Listing</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-waris-faint">
                                        Tidak ada listing barang yang sesuai dengan filter pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-waris-surface-muted">
                    {{ $items->links() }}
                </div>
            </div>

        </div>

        <!-- ================= TAB 2: MANAJEMEN MAHASISWA & SUSPEND (FR-11) ================= -->
        <div x-show="activeTab === 'users'" class="space-y-5">
            
            <form method="GET" action="{{ route('admin.dashboard') }}" class="bg-waris-surface p-4 sm:p-5 rounded-3xl border border-waris-border shadow-2xs grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="tab" value="users">

                <div class="sm:col-span-6">
                    <input type="text" 
                           name="user_search" 
                           value="{{ request('user_search') }}" 
                           placeholder="Cari nama mahasiswa, NIM, atau email..." 
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-accent focus:ring-waris-accent py-2.5 px-3 bg-waris-surface-hover text-waris-text shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <select name="user_status" 
                            class="w-full text-xs rounded-xl border-waris-border focus:border-waris-accent focus:ring-waris-accent py-2.5 px-3 bg-waris-surface text-waris-text shadow-2xs">
                        <option value="">Semua Status Akun</option>
                        <option value="active" {{ request('user_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="suspended" {{ request('user_status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspended)</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-center space-x-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-waris-accent hover:bg-waris-accent-hover text-white rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98] cursor-pointer">
                        Filter Mahasiswa
                    </button>
                    @if (request()->hasAny(['user_search', 'user_status', 'user_faculty']))
                        <a href="{{ route('admin.dashboard', ['tab' => 'users']) }}" 
                           class="py-2.5 px-3 bg-waris-surface-muted hover:bg-waris-border text-waris-text-secondary rounded-xl text-xs font-bold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabel Pengguna Mahasiswa -->
            <div class="bg-waris-surface rounded-3xl border border-waris-border shadow-2xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-waris-text-secondary">
                        <thead class="bg-waris-surface-hover text-[11px] uppercase font-bold text-waris-faint border-b border-waris-border">
                            <tr>
                                <th class="py-3.5 px-4">Sivitas Mahasiswa</th>
                                <th class="py-3.5 px-4">Program Studi & Semester</th>
                                <th class="py-3.5 px-4">Aktivitas Platform</th>
                                <th class="py-3.5 px-4">Status Akun</th>
                                <th class="py-3.5 px-4 text-right">Tindakan Moderasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-waris-surface-muted">
                            @forelse ($users as $u)
                                <tr class="hover:bg-waris-surface-hover transition-colors {{ $u->isSuspended() ? 'bg-waris-danger-soft/40' : '' }}">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $u->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=065F46&color=ffffff' }}" 
                                                 alt="{{ $u->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover border border-waris-primary/20 shrink-0">
                                            <div>
                                                <div class="flex items-center space-x-1.5">
                                                    <span class="font-bold text-waris-text text-xs">{{ $u->name }}</span>
                                                    @if ($u->nim)
                                                        <span class="font-mono text-[10px] text-waris-faint">#{{ $u->nim }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-[11px] text-waris-subtle block">{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <span class="font-bold text-waris-text block">{{ $u->study_program ?? $u->faculty ?? 'Belum Ditentukan' }}</span>
                                        <span class="text-[10px] text-waris-faint block mt-0.5">
                                            {{ $u->faculty ?? 'Fakultas' }} &bull; Semester {{ $u->semester ?? 'Aktif' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center space-x-3 text-[11px]">
                                            <span class="inline-flex items-center space-x-1 text-waris-primary font-bold">
                                                <x-icon name="package" class="w-3.5 h-3.5 text-waris-primary-muted" />
                                                <span>{{ $u->items_count }} Pasang</span>
                                            </span>
                                            <span class="text-waris-border-strong">&bull;</span>
                                            <span class="inline-flex items-center space-x-1 text-waris-accent-text font-bold">
                                                <x-icon name="clock" class="w-3.5 h-3.5 text-waris-accent" />
                                                <span>{{ $u->claims_count }} Klaim</span>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if ($u->isSuspended())
                                            <div>
                                                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-waris-danger-soft text-waris-danger-text border border-waris-danger-border">
                                                    <x-icon name="alert-triangle" class="w-3 h-3 text-waris-danger" />
                                                    <span>Ditangguhkan</span>
                                                </span>
                                                @if ($u->suspend_reason)
                                                    <p class="text-[10px] text-waris-danger-text italic mt-1 max-w-xs leading-tight">
                                                        "{{ $u->suspend_reason }}"
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-waris-primary-soft text-waris-primary border border-waris-primary-border">
                                                <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-muted"></span>
                                                <span>Aktif Normal</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4 text-right">
                                        @if ($u->isSuspended())
                                            <form method="POST" action="{{ route('admin.users.activate', $u) }}" class="inline" onsubmit="return confirm('Pulihkan status akun {{ addslashes($u->name) }} agar dapat login dan bertransaksi kembali?');">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center space-x-1 px-3 py-1.5 bg-waris-primary-soft hover:bg-waris-primary-border/40 text-waris-primary border border-waris-primary-border rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer">
                                                    <x-icon name="check" class="w-3.5 h-3.5 text-waris-primary-muted" />
                                                    <span>Pulihkan Akun</span>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" 
                                                    @click="openSuspendModal({
                                                        id: {{ $u->id }},
                                                        name: '{{ addslashes($u->name) }}',
                                                        email: '{{ addslashes($u->email) }}',
                                                        suspendUrl: '{{ route('admin.users.suspend', $u) }}'
                                                    })"
                                                    class="inline-flex items-center space-x-1 px-3 py-1.5 bg-waris-danger-soft hover:bg-waris-danger-border/40 text-waris-danger-text border border-waris-danger-border rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer"
                                                    title="Tangguhkan Akses Pengguna">
                                                <x-icon name="lock" class="w-3.5 h-3.5 text-waris-danger" />
                                                <span>Suspend Akun</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-waris-faint">
                                        Tidak ada data mahasiswa yang sesuai dengan filter pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-waris-surface-muted">
                    {{ $users->links() }}
                </div>
            </div>

        </div>

        <!-- ================= MODAL 1: KONFIRMASI HAPUS LISTING ================= -->
        <div x-show="deleteModalOpen" 
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="delete-modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="deleteModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:exit="ease-in duration-200"
                 x-transition:exit-start="opacity-100"
                 x-transition:exit-end="opacity-0"
                 class="fixed inset-0 bg-waris-text/60 backdrop-blur-xs transition-opacity"
                 @click="deleteModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="deleteModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit="ease-in duration-200"
                     x-transition:exit-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-3xl bg-waris-surface text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-waris-surface-muted p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-waris-danger-soft text-waris-danger flex items-center justify-center shrink-0 border border-waris-danger-border">
                            <x-icon name="trash" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-waris-text" id="delete-modal-title">
                                Hapus Paksa Listing Barang
                            </h3>
                            <p class="text-xs text-waris-subtle mt-0.5">
                                Tindakan moderasi pelanggaran pedoman platform
                            </p>
                        </div>
                    </div>

                    <div class="p-4 bg-waris-danger-soft rounded-2xl border border-waris-danger-border text-xs text-waris-danger-text space-y-1.5">
                        <p class="font-bold">
                            Apakah Anda yakin ingin menghapus barang <span class="underline" x-text="itemToDelete ? itemToDelete.title : ''"></span> milik <span class="underline" x-text="itemToDelete ? itemToDelete.owner : ''"></span>?
                        </p>
                        <p class="text-[11px] leading-relaxed">
                            Listing barang dan seluruh riwayat pengajuan terkait akan dihapus secara permanen dari basis data kampus waris.in.
                        </p>
                    </div>

                    <div class="pt-2 flex items-center justify-end space-x-2">
                        <button type="button" 
                                @click="deleteModalOpen = false" 
                                class="px-4 py-2.5 rounded-xl border border-waris-border-strong text-xs font-bold text-waris-text-secondary hover:bg-waris-surface-muted transition-colors cursor-pointer">
                            Batal
                        </button>
                        
                        <form :action="itemToDelete ? itemToDelete.deleteUrl : '#'" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-waris-danger hover:bg-waris-danger-hover text-white text-xs font-bold shadow-2xs hover:shadow-xs transition-colors cursor-pointer">
                                Ya, Hapus Permanen
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= MODAL 2: SUSPEND PENGGUNA ================= -->
        <div x-show="suspendModalOpen" 
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="suspend-modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="suspendModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:exit="ease-in duration-200"
                 x-transition:exit-start="opacity-100"
                 x-transition:exit-end="opacity-0"
                 class="fixed inset-0 bg-waris-text/60 backdrop-blur-xs transition-opacity"
                 @click="suspendModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="suspendModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit="ease-in duration-200"
                     x-transition:exit-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:exit-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-3xl bg-waris-surface text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-waris-surface-muted p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-waris-accent-soft text-waris-accent flex items-center justify-center shrink-0 border border-waris-accent-border">
                            <x-icon name="lock" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-waris-text" id="suspend-modal-title">
                                Tangguhkan Akun Mahasiswa
                            </h3>
                            <p class="text-xs text-waris-subtle mt-0.5">
                                Akun: <span class="font-bold text-waris-text" x-text="userToSuspend ? userToSuspend.name : ''"></span> (<span x-text="userToSuspend ? userToSuspend.email : ''"></span>)
                            </p>
                        </div>
                    </div>

                    <form :action="userToSuspend ? userToSuspend.suspendUrl : '#'" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="suspend_reason" class="block text-xs font-bold text-waris-text-secondary mb-1">
                                Alasan Penangguhan Akun <span class="text-waris-danger">*</span>
                            </label>
                            <textarea id="suspend_reason" 
                                      name="suspend_reason" 
                                      rows="3" 
                                      required
                                      placeholder="Tuliskan pelanggaran yang dilakukan (misal: menjual materi gratis perkuliahan, penipuan titik COD, spam listing)..."
                                      class="w-full text-xs rounded-xl border-waris-border focus:border-waris-accent focus:ring-waris-accent shadow-2xs leading-relaxed bg-waris-surface text-waris-text"></textarea>
                            <p class="text-[10px] text-waris-faint mt-1">
                                *Alasan ini akan otomatis ditampilkan kepada mahasiswa saat mereka mencoba login.
                            </p>
                        </div>

                        <div class="p-3 bg-waris-accent-soft rounded-xl border border-waris-accent-border text-[11px] text-waris-accent-text leading-snug">
                            Mahasiswa yang ditangguhkan akan otomatis dikeluarkan dari sesi login aktif dan tidak dapat memasang barang atau mengajukan klaim.
                        </div>

                        <div class="pt-2 flex items-center justify-end space-x-2">
                            <button type="button" 
                                    @click="suspendModalOpen = false" 
                                    class="px-4 py-2.5 rounded-xl border border-waris-border-strong text-xs font-bold text-waris-text-secondary hover:bg-waris-surface-muted transition-colors cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-waris-danger hover:bg-waris-danger-hover text-white text-xs font-bold shadow-2xs hover:shadow-xs transition-colors cursor-pointer">
                                Ya, Tangguhkan Akun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
