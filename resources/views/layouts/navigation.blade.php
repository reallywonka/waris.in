<nav x-data="{ open: false }" class="bg-waris-surface border-b border-waris-border sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- 1. Sisi Kiri: Brand Logo & Menu Navigasi Utama -->
            <div class="flex items-center space-x-8">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 group focus:outline-none">
                    <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in" class="w-8 h-8 object-contain group-hover:scale-105 transition-transform duration-200">
                    <span class="text-xl font-bold tracking-tight text-waris-text">
                        waris<span class="text-waris-primary">.in</span>
                    </span>
                </a>

                <!-- Menu Navigasi Desktop -->
                <div class="hidden md:flex items-center space-x-1.5 text-sm font-medium">
                    <!-- Beranda -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-muted hover:text-waris-primary hover:bg-waris-surface-hover' }}">
                        Beranda
                    </a>

                    <!-- Jelajahi Katalog -->
                    <a href="{{ route('items.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('items.index') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-muted hover:text-waris-primary hover:bg-waris-surface-hover' }}">
                        Jelajahi Katalog
                    </a>

                    @auth
                        <!-- Barang Saya (Task 6) -->
                        <a href="{{ route('items.my') }}" 
                           class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('items.my*') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-muted hover:text-waris-primary hover:bg-waris-surface-hover' }}">
                            Barang Saya
                        </a>

                        <!-- Pengajuan Masuk (Task 8) -->
                        @php
                            $unreadIncomingCount = \App\Models\Claim::whereHas('item', fn($q) => $q->where('user_id', auth()->id()))->where('status', 'pending')->count();
                        @endphp
                        <a href="{{ route('claims.incoming') }}" 
                           class="relative px-3.5 py-2 rounded-xl transition-all duration-150 flex items-center space-x-1.5 {{ request()->routeIs('claims.incoming*') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-muted hover:text-waris-primary hover:bg-waris-surface-hover' }}">
                            <span>Pengajuan Masuk</span>
                            @if ($unreadIncomingCount > 0)
                                <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-waris-accent rounded-full">
                                    {{ $unreadIncomingCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Pengajuan Saya (Task 9) -->
                        <a href="{{ route('claims.my') }}" 
                           class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('claims.my*') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-muted hover:text-waris-primary hover:bg-waris-surface-hover' }}">
                            Pengajuan Saya
                        </a>

                        <!-- Pasang Barang (Warm Amber Accent CTA) -->
                        <a href="{{ route('items.create') }}" 
                           class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl transition-all duration-150 font-semibold text-xs {{ request()->routeIs('items.create') ? 'bg-waris-accent-hover text-white shadow-xs' : 'bg-waris-accent hover:bg-waris-accent-hover active:bg-waris-accent-active text-white shadow-2xs' }}">
                            <x-icon name="plus" class="w-4 h-4" />
                            <span>Pasang Barang</span>
                        </a>

                        @if (Auth::user()->isAdmin())
                            <!-- Portal Admin Moderasi -->
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all duration-150 {{ request()->routeIs('admin*') ? 'bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border shadow-2xs' : 'bg-waris-surface-muted text-waris-text-secondary hover:bg-waris-border border border-waris-border' }}">
                                <x-icon name="shield" class="w-3.5 h-3.5 text-waris-accent" />
                                <span>Portal Admin</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- 2. Sisi Kanan: Akun Mahasiswa / Tombol Masuk Desktop -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <!-- Pill Profile Dropdown (Hover & Click Friendly) -->
                    <div class="relative group" 
                         x-data="{ isOpen: false }" 
                         @mouseleave="isOpen = false"
                         @click.outside="isOpen = false"
                         @keydown.escape.window="isOpen = false">
                        <button type="button" 
                                @click="isOpen = !isOpen" 
                                class="flex items-center space-x-3 p-1.5 pe-4 bg-waris-surface-hover hover:bg-waris-primary-soft border border-waris-border hover:border-waris-primary-border rounded-full transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-waris-primary cursor-pointer">
                            <!-- Avatar -->
                            <img class="w-8 h-8 rounded-full object-cover border border-waris-primary/20" 
                                 src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=065F46&color=ffffff' }}" 
                                 referrerpolicy="no-referrer"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=065F46&color=ffffff';"
                                 alt="{{ Auth::user()->name }}">
                            
                            <!-- Nama & Program Studi -->
                            <div class="text-left text-xs">
                                <div class="font-bold text-waris-text leading-tight truncate max-w-36">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-waris-primary-muted font-medium text-[10px] truncate max-w-36">
                                    {{ Auth::user()->study_program ?? (Auth::user()->role === 'admin' ? 'Admin Kampus' : 'Mahasiswa') }}
                                </div>
                            </div>

                            <!-- Panah Bawah -->
                            <x-icon name="chevron-down" 
                                    class="w-3.5 h-3.5 text-waris-faint transition-transform duration-200 group-hover:rotate-180" 
                                    ::class="isOpen ? 'rotate-180 text-waris-primary-muted' : ''" />
                        </button>

                        <!-- Menu Dropdown -->
                        <div class="absolute right-0 top-full pt-1.5 w-64 z-50 transition-all duration-150"
                             :class="isOpen ? 'block' : 'hidden group-hover:block'">
                            
                            <div class="bg-waris-surface rounded-2xl shadow-xl border border-waris-border py-2 divide-y divide-waris-surface-muted">
                                <!-- Ringkasan Info Mahasiswa -->
                                <div class="px-4 py-3 bg-waris-surface-hover">
                                    <p class="text-[10px] uppercase font-bold text-waris-faint tracking-wider">Akun Mahasiswa</p>
                                    <p class="text-xs font-bold text-waris-text truncate mt-0.5">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-waris-subtle truncate">{{ Auth::user()->email }}</p>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        <span class="inline-flex items-center text-[10px] font-bold text-waris-primary bg-waris-primary-soft px-2 py-0.5 rounded-md border border-waris-primary-border">
                                            {{ Auth::user()->study_program ?? 'Program Studi' }} &bull; Smt {{ Auth::user()->semester ?? 1 }}
                                        </span>
                                        @if(Auth::user()->nim)
                                            <span class="inline-flex items-center text-[10px] font-semibold text-waris-muted bg-waris-surface-muted px-2 py-0.5 rounded-md">
                                                NIM: {{ Auth::user()->nim }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Menu Akses Cepat Transaksi & Listing -->
                                <div class="p-1.5 space-y-0.5">
                                    <a href="{{ route('items.my') }}" 
                                       class="w-full text-left px-3 py-2 text-xs font-semibold text-waris-text-secondary hover:bg-waris-primary-soft hover:text-waris-primary rounded-xl flex items-center justify-between transition-colors">
                                        <div class="flex items-center space-x-2">
                                            <x-icon name="package" class="w-4 h-4 text-waris-primary-muted" />
                                            <span>Barang Saya</span>
                                        </div>
                                        <x-icon name="chevron-right" class="w-3.5 h-3.5 text-waris-faint" />
                                    </a>

                                    <a href="{{ route('claims.incoming') }}" 
                                       class="w-full text-left px-3 py-2 text-xs font-semibold text-waris-text-secondary hover:bg-waris-primary-soft hover:text-waris-primary rounded-xl flex items-center justify-between transition-colors">
                                        <div class="flex items-center space-x-2">
                                            <x-icon name="inbox" class="w-4 h-4 text-waris-primary-muted" />
                                            <span>Pengajuan Masuk</span>
                                        </div>
                                        @if (isset($unreadIncomingCount) && $unreadIncomingCount > 0)
                                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-waris-accent rounded-full">
                                                {{ $unreadIncomingCount }}
                                            </span>
                                        @else
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-waris-faint" />
                                        @endif
                                    </a>

                                    <a href="{{ route('claims.my') }}" 
                                       class="w-full text-left px-3 py-2 text-xs font-semibold text-waris-text-secondary hover:bg-waris-primary-soft hover:text-waris-primary rounded-xl flex items-center justify-between transition-colors">
                                        <div class="flex items-center space-x-2">
                                            <x-icon name="clock" class="w-4 h-4 text-waris-primary-muted" />
                                            <span>Pengajuan Saya</span>
                                        </div>
                                        <x-icon name="chevron-right" class="w-3.5 h-3.5 text-waris-faint" />
                                    </a>

                                    @if (Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="w-full text-left px-3 py-2 text-xs font-bold text-waris-accent-text bg-waris-accent-soft hover:bg-waris-accent-border/40 rounded-xl flex items-center justify-between transition-colors">
                                            <div class="flex items-center space-x-2">
                                                <x-icon name="shield" class="w-4 h-4 text-waris-accent" />
                                                <span>Portal Moderasi Admin</span>
                                            </div>
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-waris-accent" />
                                        </a>
                                    @endif
                                </div>

                                <!-- Tombol Keluar Sesi -->
                                <div class="p-1.5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-waris-danger hover:bg-waris-danger-soft rounded-xl flex items-center space-x-2.5 transition-colors cursor-pointer">
                                            <x-icon name="log-out" class="w-4 h-4 text-waris-danger" />
                                            <span>Keluar Sesi</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tombol Masuk & Daftar untuk Tamu -->
                    <a href="{{ route('login') }}" 
                       class="text-xs font-bold text-waris-text-secondary hover:text-waris-primary px-4 py-2 rounded-xl hover:bg-waris-surface-hover transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center space-x-1.5 text-xs font-bold text-white bg-waris-primary hover:bg-waris-primary-hover px-4 py-2.5 rounded-xl transition-colors focus-visible:ring-2 focus-visible:ring-waris-primary">
                        <span>Daftar Sekarang</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </a>
                @endauth
            </div>

            <!-- 3. Tombol Hamburger Menu (Mobile & Tablet) -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" 
                        aria-label="Buka Menu Navigasi"
                        class="p-2.5 rounded-xl text-waris-text-secondary hover:text-waris-primary hover:bg-waris-primary-soft transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-waris-primary">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Menu Drawer Mobile & Tablet (Responsive & Thumb-Friendly) -->
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:exit="transition ease-in duration-150"
         x-transition:exit-start="opacity-100 translate-y-0"
         x-transition:exit-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-waris-border bg-waris-surface px-4 pt-3 pb-6 space-y-2 shadow-lg">
        
        <div class="space-y-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-text-secondary hover:bg-waris-surface-hover' }}">
                <x-icon name="package" class="w-4 h-4 text-waris-primary" />
                <span>Beranda</span>
            </a>
            <a href="{{ route('items.index') }}" 
               class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('items.index') ? 'bg-waris-primary-soft text-waris-primary font-bold' : 'text-waris-text-secondary hover:bg-waris-surface-hover' }}">
                <x-icon name="search" class="w-4 h-4 text-waris-primary" />
                <span>Jelajahi Katalog</span>
            </a>
            
            @auth
                <a href="{{ route('items.create') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl bg-waris-accent-soft text-waris-accent-text border border-waris-accent-border font-bold transition-colors">
                    <x-icon name="plus" class="w-4 h-4 text-waris-accent" />
                    <span>Pasang Barang Baru</span>
                </a>
                <a href="{{ route('claims.incoming') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-waris-text-secondary hover:bg-waris-surface-hover transition-colors">
                    <x-icon name="inbox" class="w-4 h-4 text-waris-primary-muted" />
                    <span>Pengajuan Masuk</span>
                </a>
                <a href="{{ route('items.my') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-waris-text-secondary hover:bg-waris-surface-hover transition-colors">
                    <x-icon name="package" class="w-4 h-4 text-waris-primary-muted" />
                    <span>Barang Saya</span>
                </a>
                <a href="{{ route('claims.my') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-waris-text-secondary hover:bg-waris-surface-hover transition-colors">
                    <x-icon name="clock" class="w-4 h-4 text-waris-accent" />
                    <span>Pengajuan Saya</span>
                </a>

                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-waris-accent-text bg-waris-accent-soft hover:bg-waris-accent-border/40 border border-waris-accent-border font-bold transition-colors">
                        <x-icon name="shield" class="w-4 h-4 text-waris-accent" />
                        <span>Portal Moderasi Admin</span>
                    </a>
                @endif
            @endauth
        </div>

        <div class="border-t border-waris-surface-muted pt-3 mt-2">
            @auth
                <div class="flex items-center space-x-3 px-3 py-2.5 bg-waris-surface-hover rounded-2xl mb-2">
                    <img class="w-10 h-10 rounded-full object-cover border border-waris-primary/20 shrink-0" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=065F46&color=ffffff' }}" 
                         referrerpolicy="no-referrer"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=065F46&color=ffffff';"
                         alt="{{ Auth::user()->name }}">
                    <div class="truncate">
                        <div class="font-bold text-waris-text text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-waris-primary-muted truncate">{{ Auth::user()->study_program ?? Auth::user()->faculty ?? 'Mahasiswa Kampus' }} &bull; Semester {{ Auth::user()->semester ?? 1 }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center space-x-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-waris-text-secondary hover:bg-waris-surface-hover">
                        <x-icon name="settings" class="w-4 h-4 text-waris-subtle" />
                        <span>Pengaturan Profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-waris-danger hover:bg-waris-danger-soft flex items-center space-x-2">
                            <x-icon name="log-out" class="w-4 h-4 text-waris-danger" />
                            <span>Keluar Sesi</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('login') }}" 
                       class="w-full text-center py-3 text-xs font-bold text-waris-text-secondary border border-waris-border rounded-xl hover:bg-waris-surface-hover">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                       class="w-full text-center py-3 text-xs font-bold text-white bg-waris-primary rounded-xl hover:bg-waris-primary-hover">
                        Daftar Akun
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
