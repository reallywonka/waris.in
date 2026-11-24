<x-app-layout>
    <script>
        window.openSuspendModal = function(user) {
            console.log('[Admin Portal] Membuka modal suspend untuk:', user);
            const modal = document.getElementById('suspendModalWrapper');
            if (modal) {
                modal.removeAttribute('x-cloak');
                modal.style.display = 'block';
            }
            const nameEl = document.getElementById('suspendModalUserName');
            if (nameEl) nameEl.textContent = user.name || '';
            const emailEl = document.getElementById('suspendModalUserEmail');
            if (emailEl) emailEl.textContent = user.email || '';
            const formEl = document.getElementById('suspendModalForm');
            if (formEl && user.suspendUrl) {
                formEl.action = user.suspendUrl;
            }
            const reasonInput = document.getElementById('suspend_reason');
            if (reasonInput) {
                reasonInput.value = '';
                setTimeout(() => reasonInput.focus(), 80);
            }
            try {
                const rootEl = document.getElementById('adminDashboardRoot');
                if (rootEl && window.Alpine && Alpine.$data) {
                    const d = Alpine.$data(rootEl);
                    if (d) {
                        d.userToSuspend = user;
                        d.suspendModalOpen = true;
                    }
                }
            } catch(e) {}
        };

        window.closeSuspendModal = function() {
            console.log('[Admin Portal] Menutup modal suspend');
            const modal = document.getElementById('suspendModalWrapper');
            if (modal) {
                modal.style.display = 'none';
            }
            try {
                const rootEl = document.getElementById('adminDashboardRoot');
                if (rootEl && window.Alpine && Alpine.$data) {
                    const d = Alpine.$data(rootEl);
                    if (d) d.suspendModalOpen = false;
                }
            } catch(e) {}
        };

        window.openDeleteModal = function(item) {
            console.log('[Admin Portal] Membuka modal hapus listing:', item);
            const modal = document.getElementById('deleteModalWrapper');
            if (modal) {
                modal.removeAttribute('x-cloak');
                modal.style.display = 'block';
            }
            const titleEl = document.getElementById('deleteModalItemTitle');
            if (titleEl) titleEl.textContent = item.title || '';
            const ownerEl = document.getElementById('deleteModalItemOwner');
            if (ownerEl) ownerEl.textContent = item.owner || '';
            const formEl = document.getElementById('deleteModalForm');
            if (formEl && item.deleteUrl) {
                formEl.action = item.deleteUrl;
            }
            try {
                const rootEl = document.getElementById('adminDashboardRoot');
                if (rootEl && window.Alpine && Alpine.$data) {
                    const d = Alpine.$data(rootEl);
                    if (d) {
                        d.itemToDelete = item;
                        d.deleteModalOpen = true;
                    }
                }
            } catch(e) {}
        };

        window.closeDeleteModal = function() {
            console.log('[Admin Portal] Menutup modal hapus listing');
            const modal = document.getElementById('deleteModalWrapper');
            if (modal) {
                modal.style.display = 'none';
            }
            try {
                const rootEl = document.getElementById('adminDashboardRoot');
                if (rootEl && window.Alpine && Alpine.$data) {
                    const d = Alpine.$data(rootEl);
                    if (d) d.deleteModalOpen = false;
                }
            } catch(e) {}
        };
    </script>
    <div id="adminDashboardRoot"
         x-data="{
            activeTab: '{{ request('tab', $tab ?? 'items') }}',
            deleteModalOpen: false,
            itemToDelete: null,
            suspendModalOpen: false,
            userToSuspend: null,
            openDeleteModal(item) {
                window.openDeleteModal(item);
            },
            openSuspendModal(user) {
                window.openSuspendModal(user);
            },
            closeDeleteModal() {
                window.closeDeleteModal();
            },
            closeSuspendModal() {
                window.closeSuspendModal();
            }
         }" 
         class="space-y-8 pb-16">

        <!-- 1. Header Halaman Moderasi Admin -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    <span>/</span>
                    <span class="text-amber-800 font-bold">Portal Moderasi Admin</span>
                </nav>
                <div class="flex items-center space-x-2.5">
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                        Portal Moderasi Kampus
                    </h1>
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-xl text-xs font-black bg-amber-100 text-amber-900 border border-amber-300 shadow-2xs">
                        <x-icon name="shield" class="w-3.5 h-3.5 text-amber-700" />
                        <span>Admin Privileged</span>
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Pengawasan ketertiban listing barang perkuliahan dan manajemen penangguhan akun sivitas akademika waris.in.
                </p>
            </div>

            <div class="flex items-center space-x-2.5">
                <a href="{{ route('items.index') }}" 
                   class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:border-emerald-300 text-gray-700 hover:text-emerald-900 rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98]">
                    <x-icon name="search" class="w-4 h-4 text-emerald-700" />
                    <span>Lihat Katalog Publik</span>
                </a>
            </div>
        </div>

        <!-- 2. Ringkasan Metrik Platform -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Mahasiswa Terdaftar</span>
                    <span class="text-2xl font-black text-gray-900 block mt-1">{{ $totalStudents }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                    <x-icon name="users" class="w-5 h-5 text-emerald-700" />
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Listing Barang</span>
                    <span class="text-2xl font-black text-emerald-800 block mt-1">{{ $totalItems }}</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                    <x-icon name="package" class="w-5 h-5 text-emerald-700" />
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Sirkulasi Aktif</span>
                    <span class="text-2xl font-black text-emerald-600 block mt-1">{{ $activeItems }}</span>
                    <span class="text-[10px] text-gray-400 block mt-0.5">{{ $lockedItems }} Terkunci / Deal</span>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Akun Ditangguhkan</span>
                    <span class="text-2xl font-black {{ $suspendedStudents > 0 ? 'text-rose-600' : 'text-gray-900' }} block mt-1">{{ $suspendedStudents }}</span>
                    <span class="text-[10px] text-gray-400 block mt-0.5">Pelanggaran Komunitas</span>
                </div>
                <div class="w-10 h-10 rounded-2xl {{ $suspendedStudents > 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-gray-50 text-gray-500 border-gray-200' }} flex items-center justify-center border">
                    <x-icon name="alert-triangle" class="w-5 h-5" />
                </div>
            </div>
        </div>

        <!-- 3. Tab Navigasi Moderasi (Barang vs Mahasiswa) -->
        <div class="flex items-center space-x-3 border-b border-gray-200 pb-3">
            <button type="button" 
                    @click="activeTab = 'items'" 
                    class="px-5 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center space-x-2 cursor-pointer active:scale-[0.98]"
                    :class="activeTab === 'items' 
                        ? 'bg-emerald-800 text-white shadow-2xs' 
                        : 'bg-white text-gray-600 hover:text-emerald-900 border border-gray-200 hover:border-emerald-300'">
                <x-icon name="package" class="w-4 h-4" />
                <span>Moderasi Listing Barang (FR-10)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                      :class="activeTab === 'items' ? 'bg-emerald-900 text-emerald-200' : 'bg-gray-100 text-gray-600'">
                    {{ $items->total() }}
                </span>
            </button>

            <button type="button" 
                    @click="activeTab = 'users'" 
                    class="px-5 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center space-x-2 cursor-pointer active:scale-[0.98]"
                    :class="activeTab === 'users' 
                        ? 'bg-amber-700 text-white shadow-2xs' 
                        : 'bg-white text-gray-600 hover:text-amber-900 border border-gray-200 hover:border-amber-300'">
                <x-icon name="users" class="w-4 h-4" />
                <span>Kelola Mahasiswa & Suspend (FR-11)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                      :class="activeTab === 'users' ? 'bg-amber-800 text-amber-200' : 'bg-gray-100 text-gray-600'">
                    {{ $users->total() }}
                </span>
            </button>
        </div>

        <!-- ================= TAB 1: MODERASI LISTING BARANG (FR-10) ================= -->
        <div x-show="activeTab === 'items'" class="space-y-5">
            
            <!-- Filter & Pencarian Barang -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-2xs grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="tab" value="items">

                <div class="sm:col-span-6">
                    <input type="text" 
                           name="item_search" 
                           value="{{ request('item_search') }}" 
                           placeholder="Cari judul barang, deskripsi, atau nama pemilik..." 
                           class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-gray-50/50 shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <select name="item_status" 
                            class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-white shadow-2xs">
                        <option value="">Semua Status Barang</option>
                        <option value="available" {{ request('item_status') === 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="locked" {{ request('item_status') === 'locked' ? 'selected' : '' }}>Terkunci (Deal)</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-center space-x-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98] cursor-pointer">
                        Filter Listing
                    </button>
                    @if (request()->hasAny(['item_search', 'item_status', 'item_mode']))
                        <a href="{{ route('admin.dashboard', ['tab' => 'items']) }}" 
                           class="py-2.5 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabel Listing Barang -->
            <div class="bg-white rounded-3xl border border-gray-200 shadow-2xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700">
                        <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-400 border-b border-gray-200">
                            <tr>
                                <th class="py-3.5 px-4">Barang</th>
                                <th class="py-3.5 px-4">Pemilik (Mahasiswa)</th>
                                <th class="py-3.5 px-4">Format Transaksi</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4">Dipasang</th>
                                <th class="py-3.5 px-4 text-right">Tindakan Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($items as $item)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $item->primary_image_url }}" 
                                                 alt="{{ $item->title }}" 
                                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholders/default.svg') }}';"
                                                 class="w-12 h-12 rounded-xl object-cover border border-gray-200 shrink-0">
                                            <div class="min-w-0">
                                                <a href="{{ route('items.show', $item) }}" target="_blank" class="font-bold text-gray-900 hover:text-emerald-800 transition-colors line-clamp-1">
                                                    {{ $item->title }}
                                                </a>
                                                <span class="text-[10px] text-gray-400 block mt-0.5">
                                                    {{ $item->category }} &bull; {{ $item->condition }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($item->user->name).'&background=144d37&color=ffffff' }}" 
                                                 alt="{{ $item->user->name }}" 
                                                 class="w-7 h-7 rounded-full object-cover border border-emerald-700/20 shrink-0">
                                            <div>
                                                <span class="font-bold text-gray-900 block truncate max-w-32">{{ $item->user->name }}</span>
                                                <span class="text-[10px] text-gray-400 block truncate max-w-32">{{ $item->user->faculty ?? 'Mahasiswa' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black {{ $item->mode === 'harga_pas' ? 'bg-amber-50 text-amber-900 border border-amber-200' : ($item->mode === 'barter' ? 'bg-teal-50 text-teal-900 border border-teal-200' : 'bg-emerald-50 text-emerald-900 border border-emerald-200') }}">
                                            {{ $item->formatted_price }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4">
                                        @if ($item->status === 'available')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Tersedia</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                <x-icon name="lock" class="w-3 h-3 text-gray-400" />
                                                <span>Terkunci</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4 text-gray-500 text-[11px]">
                                        {{ $item->created_at->format('d M Y') }}
                                        <span class="text-gray-400 block text-[10px]">{{ $item->created_at->diffForHumans() }}</span>
                                    </td>

                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end space-x-1.5">
                                            <a href="{{ route('items.show', $item) }}" 
                                               target="_blank" 
                                               class="p-2 rounded-xl bg-gray-100 hover:bg-emerald-50 hover:text-emerald-800 text-gray-600 transition-colors" 
                                               title="Buka Halaman Barang">
                                                <x-icon name="link" class="w-3.5 h-3.5" />
                                            </a>

                                            <!-- Tombol Hapus Paksa Listing (FR-10) -->
                                            <button type="button" 
                                                    onclick="window.openDeleteModal({
                                                        id: {{ $item->id }},
                                                        title: {{ json_encode($item->title) }},
                                                        owner: {{ json_encode($item->user->name ?? 'Mahasiswa') }},
                                                        deleteUrl: {{ json_encode(route('admin.items.destroy', $item)) }}
                                                    })"
                                                    @click="openDeleteModal({
                                                        id: {{ $item->id }},
                                                        title: {{ json_encode($item->title) }},
                                                        owner: {{ json_encode($item->user->name ?? 'Mahasiswa') }},
                                                        deleteUrl: {{ json_encode(route('admin.items.destroy', $item)) }}
                                                    })"
                                                    class="inline-flex items-center space-x-1 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer"
                                                    title="Hapus Listing Pelanggaran">
                                                <x-icon name="trash" class="w-3.5 h-3.5 text-rose-600" />
                                                <span>Hapus Listing</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        Tidak ada listing barang yang sesuai dengan filter pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100">
                    {{ $items->links() }}
                </div>
            </div>

        </div>

        <!-- ================= TAB 2: MANAJEMEN MAHASISWA & SUSPEND (FR-11) ================= -->
        <div x-show="activeTab === 'users'" class="space-y-5">
            
            <!-- Filter & Pencarian Pengguna -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-2xs grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="tab" value="users">

                <div class="sm:col-span-6">
                    <input type="text" 
                           name="user_search" 
                           value="{{ request('user_search') }}" 
                           placeholder="Cari nama mahasiswa, NIM, atau email..." 
                           class="w-full text-xs rounded-xl border-gray-200 focus:border-amber-600 focus:ring-amber-600 py-2.5 px-3 bg-gray-50/50 shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <select name="user_status" 
                            class="w-full text-xs rounded-xl border-gray-200 focus:border-amber-600 focus:ring-amber-600 py-2.5 px-3 bg-white shadow-2xs">
                        <option value="">Semua Status Akun</option>
                        <option value="active" {{ request('user_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="suspended" {{ request('user_status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspended)</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-center space-x-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-amber-700 hover:bg-amber-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs active:scale-[0.98] cursor-pointer">
                        Filter Mahasiswa
                    </button>
                    @if (request()->hasAny(['user_search', 'user_status', 'user_faculty']))
                        <a href="{{ route('admin.dashboard', ['tab' => 'users']) }}" 
                           class="py-2.5 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabel Pengguna Mahasiswa -->
            <div class="bg-white rounded-3xl border border-gray-200 shadow-2xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700">
                        <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-400 border-b border-gray-200">
                            <tr>
                                <th class="py-3.5 px-4">Sivitas Mahasiswa</th>
                                <th class="py-3.5 px-4">Program Studi & Semester</th>
                                <th class="py-3.5 px-4">Aktivitas Platform</th>
                                <th class="py-3.5 px-4">Status Akun</th>
                                <th class="py-3.5 px-4 text-right">Tindakan Moderasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $u)
                                <tr class="hover:bg-gray-50/70 transition-colors {{ $u->isSuspended() ? 'bg-rose-50/30' : '' }}">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $u->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=144d37&color=ffffff' }}" 
                                                 alt="{{ $u->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover border border-emerald-700/20 shrink-0">
                                            <div>
                                                <div class="flex items-center space-x-1.5">
                                                    <span class="font-bold text-gray-900 text-xs">{{ $u->name }}</span>
                                                    @if ($u->nim)
                                                        <span class="font-mono text-[10px] text-gray-400">#{{ $u->nim }}</span>
                                                    @endif
                                                </div>
                                                <span class="text-[11px] text-gray-500 block">{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <span class="font-bold text-gray-800 block">{{ $u->study_program ?? $u->faculty ?? 'Belum Ditentukan' }}</span>
                                        <span class="text-[10px] text-gray-400 block mt-0.5">
                                            {{ $u->faculty ?? 'Fakultas' }} &bull; Semester {{ $u->semester ?? 'Aktif' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center space-x-3 text-[11px]">
                                            <span class="inline-flex items-center space-x-1 text-emerald-800 font-bold">
                                                <x-icon name="package" class="w-3.5 h-3.5 text-emerald-700" />
                                                <span>{{ $u->items_count }} Pasang</span>
                                            </span>
                                            <span class="text-gray-300">&bull;</span>
                                            <span class="inline-flex items-center space-x-1 text-amber-800 font-bold">
                                                <x-icon name="clock" class="w-3.5 h-3.5 text-amber-600" />
                                                <span>{{ $u->claims_count }} Klaim</span>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if ($u->isSuspended())
                                            <div>
                                                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-200">
                                                    <x-icon name="alert-triangle" class="w-3 h-3 text-rose-700" />
                                                    <span>Ditangguhkan</span>
                                                </span>
                                                @if ($u->suspend_reason)
                                                    <p class="text-[10px] text-rose-800 italic mt-1 max-w-xs leading-tight">
                                                        "{{ $u->suspend_reason }}"
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Aktif Normal</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4 text-right">
                                        @if ($u->isSuspended())
                                            <!-- Tombol Pulihkan Akun -->
                                            <form method="POST" 
                                                  action="{{ route('admin.users.activate', $u) }}" 
                                                  class="inline"
                                                  data-confirm="Pulihkan status akun {{ addslashes($u->name) }} agar dapat login dan bertransaksi kembali di platform waris.in?"
                                                  data-confirm-title="Pulihkan Status Akun Mahasiswa?"
                                                  data-confirm-button="Ya, Pulihkan Akun"
                                                  data-confirm-color="emerald"
                                                  data-confirm-icon="check-circle"
                                                  data-confirm-note="Mahasiswa akan dapat kembali mengakses seluruh fitur pasang barang, klaim hibah, dan transaksi barter.">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center space-x-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer">
                                                    <x-icon name="check" class="w-3.5 h-3.5 text-emerald-700" />
                                                    <span>Pulihkan Akun</span>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Tombol Suspend Akun (FR-11) -->
                                            <button type="button" 
                                                    onclick="window.openSuspendModal({
                                                        id: {{ $u->id }},
                                                        name: {{ json_encode($u->name) }},
                                                        email: {{ json_encode($u->email) }},
                                                        suspendUrl: {{ json_encode(route('admin.users.suspend', $u)) }}
                                                    })"
                                                    @click="openSuspendModal({
                                                        id: {{ $u->id }},
                                                        name: {{ json_encode($u->name) }},
                                                        email: {{ json_encode($u->email) }},
                                                        suspendUrl: {{ json_encode(route('admin.users.suspend', $u)) }}
                                                    })"
                                                    class="inline-flex items-center space-x-1 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-bold transition-all active:scale-[0.98] cursor-pointer"
                                                    title="Tangguhkan Akses Pengguna">
                                                <x-icon name="lock" class="w-3.5 h-3.5 text-rose-600" />
                                                <span>Suspend Akun</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400">
                                        Tidak ada data mahasiswa yang sesuai dengan filter pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>

        </div>

        <!-- ================= MODAL 1: KONFIRMASI HAPUS LISTING (FR-10) ================= -->
        <div id="deleteModalWrapper"
             x-show="deleteModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="delete-modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
                 onclick="window.closeDeleteModal()"
                 @click="closeDeleteModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 border border-rose-200">
                            <x-icon name="trash" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900" id="delete-modal-title">
                                Hapus Paksa Listing Barang
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Tindakan moderasi pelanggaran pedoman platform
                            </p>
                        </div>
                    </div>

                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-200 text-xs text-rose-900 space-y-1.5">
                        <p class="font-bold">
                            Apakah Anda yakin ingin menghapus barang <span id="deleteModalItemTitle" class="font-black" x-text="itemToDelete ? itemToDelete.title : ''"></span> milik <span id="deleteModalItemOwner" class="font-black" x-text="itemToDelete ? itemToDelete.owner : ''"></span>?
                        </p>
                        <p class="text-[11px] text-rose-800 leading-relaxed">
                            Listing barang dan seluruh riwayat pengajuan terkait akan dihapus secara permanen dari basis data kampus waris.in.
                        </p>
                    </div>

                    <div class="pt-2 flex items-center justify-end space-x-2">
                        <button type="button" 
                                onclick="window.closeDeleteModal()"
                                @click="closeDeleteModal()" 
                                class="px-4 py-2.5 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer">
                            Batal
                        </button>
                        
                        <form id="deleteModalForm" :action="itemToDelete ? itemToDelete.deleteUrl : '#'" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tab" value="items">
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black shadow-2xs hover:shadow-xs transition-colors cursor-pointer">
                                Ya, Hapus Permanen
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= MODAL 2: SUSPEND PENGGUNA (FR-11) ================= -->
        <div id="suspendModalWrapper"
             x-show="suspendModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="suspend-modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
                 onclick="window.closeSuspendModal()"
                 @click="closeSuspendModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6 space-y-4">
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 border border-amber-200">
                            <x-icon name="lock" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900" id="suspend-modal-title">
                                Tangguhkan Akun Mahasiswa
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Akun: <span id="suspendModalUserName" class="font-bold text-gray-800" x-text="userToSuspend ? userToSuspend.name : ''"></span> (<span id="suspendModalUserEmail" x-text="userToSuspend ? userToSuspend.email : ''"></span>)
                            </p>
                        </div>
                    </div>

                    <form id="suspendModalForm" :action="userToSuspend ? userToSuspend.suspendUrl : '#'" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="tab" value="users">

                        <div>
                            <label for="suspend_reason" class="block text-xs font-bold text-gray-700 mb-1">
                                Alasan Penangguhan Akun <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="suspend_reason" 
                                      name="suspend_reason" 
                                      rows="3" 
                                      required
                                      placeholder="Tuliskan pelanggaran yang dilakukan (misal: menjual materi gratis perkuliahan, penipuan titik COD, spam listing)..."
                                      class="w-full text-xs rounded-xl border-gray-300 focus:border-amber-600 focus:ring-amber-600 shadow-2xs leading-relaxed"></textarea>
                            <p class="text-[10px] text-gray-400 mt-1">
                                *Alasan ini akan otomatis ditampilkan kepada mahasiswa saat mereka mencoba login.
                            </p>
                        </div>

                        <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-[11px] text-amber-900 leading-snug">
                            ⚠️ Mahasiswa yang ditangguhkan akan otomatis dikeluarkan dari sesi login aktif dan tidak dapat memasang barang atau mengajukan klaim.
                        </div>

                        <div class="pt-2 flex items-center justify-end space-x-2">
                            <button type="button" 
                                    onclick="window.closeSuspendModal()"
                                    @click="closeSuspendModal()" 
                                    class="px-4 py-2.5 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black shadow-2xs hover:shadow-xs transition-colors cursor-pointer">
                                Ya, Tangguhkan Akun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
