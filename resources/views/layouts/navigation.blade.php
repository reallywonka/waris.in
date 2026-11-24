<nav x-data="{ open: false }" @keydown.escape.window="open = false" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- 1. Top Tier: Brand Logo, Nav Links, & User Authentication -->
    <div class="border-b border-gray-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                
                <!-- Sisi Kiri: Brand Logo & Menu Navigasi Utama -->
                <div class="flex items-center space-x-6 lg:space-x-8">
                    <!-- Brand Logo (seperti logo Shopee di kiri atas) -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 shrink-0 group focus:outline-none">
                        <img src="{{ asset('images/logo-symbol.svg') }}" alt="waris.in logo" class="w-8 h-8 object-contain group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xl font-black tracking-tight text-gray-900">
                            waris<span class="text-emerald-700">.in</span>
                        </span>
                    </a>

                    <!-- Navigasi Menu Desktop -->
                    <div class="hidden md:flex items-center space-x-1 lg:space-x-2 text-xs font-bold text-gray-700">
                        <a href="{{ route('dashboard') }}" 
                           class="px-3 py-1.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-emerald-800 bg-emerald-50' : 'hover:text-emerald-800 hover:bg-gray-50' }}">
                            Beranda
                        </a>
                        <a href="{{ route('items.index') }}" 
                           class="px-3 py-1.5 rounded-lg transition-colors {{ request()->routeIs('items.index') ? 'text-emerald-800 bg-emerald-50' : 'hover:text-emerald-800 hover:bg-gray-50' }}">
                            Jelajahi Katalog
                        </a>
                        @auth
                            <a href="{{ route('items.my') }}" 
                               class="px-3 py-1.5 rounded-lg transition-colors {{ request()->routeIs('items.my*') ? 'text-emerald-800 bg-emerald-50' : 'hover:text-emerald-800 hover:bg-gray-50' }}">
                                Barang Saya
                            </a>

                            @php
                                $unreadIncomingCount = \App\Models\Claim::whereHas('item', fn($q) => $q->where('user_id', auth()->id()))->where('status', 'pending')->count();
                            @endphp
                            <a href="{{ route('claims.incoming') }}" 
                               class="relative px-3 py-1.5 rounded-lg transition-colors flex items-center space-x-1 {{ request()->routeIs('claims.incoming*') ? 'text-emerald-800 bg-emerald-50' : 'hover:text-emerald-800 hover:bg-gray-50' }}">
                                <span>Pengajuan Masuk</span>
                                @if ($unreadIncomingCount > 0)
                                    <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-black leading-none text-white bg-amber-500 rounded-full">
                                        {{ $unreadIncomingCount }}
                                    </span>
                                @endif
                            </a>

                            <a href="{{ route('claims.my') }}" 
                               class="px-3 py-1.5 rounded-lg transition-colors {{ request()->routeIs('claims.my*') ? 'text-emerald-800 bg-emerald-50' : 'hover:text-emerald-800 hover:bg-gray-50' }}">
                                Pengajuan Saya
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Sisi Kanan: Akun & Tombol Aksi (Sign in / Cart equivalent) -->
                <div class="hidden md:flex items-center space-x-3 lg:space-x-4">
                    @auth
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-full text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 hover:bg-amber-100 transition-colors">
                                <x-icon name="shield" class="w-3.5 h-3.5 text-amber-700" />
                                <span>Portal Admin</span>
                            </a>
                        @endif

                        <!-- Pasang Barang CTA (Cart equivalent di Shopee) -->
                        <a href="{{ route('items.create') }}" 
                           class="inline-flex items-center space-x-1.5 px-4 py-2 bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-bold text-xs rounded-full shadow-2xs transition-colors cursor-pointer">
                            <x-icon name="plus" class="w-3.5 h-3.5" />
                            <span>Pasang Barang</span>
                        </a>

                        <!-- Dropdown Profil -->
                        <div class="relative" 
                             x-data="{ isOpen: false }" 
                             @mouseleave="isOpen = false"
                             @click.outside="isOpen = false"
                             @keydown.escape.window="isOpen = false">
                            <button type="button" 
                                    @click="isOpen = !isOpen" 
                                    class="flex items-center space-x-2 p-1 pe-2.5 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-300 rounded-full transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 cursor-pointer">
                                <img class="w-7 h-7 rounded-full object-cover border border-emerald-700/20" 
                                     src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                                     referrerpolicy="no-referrer"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=144d37&color=ffffff';"
                                     alt="{{ Auth::user()->name }}">
                                <span class="text-xs font-bold text-gray-900 truncate max-w-28 text-left">
                                    {{ Auth::user()->name }}
                                </span>
                                <x-icon name="chevron-down" 
                                        class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" 
                                        ::class="isOpen ? 'rotate-180 text-emerald-700' : ''" />
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 top-full pt-1.5 w-64 z-50 transition-all duration-150"
                                 :class="isOpen ? 'block' : 'hidden group-hover:block'">
                                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 py-2 divide-y divide-gray-100">
                                    <div class="px-4 py-3 bg-gray-50/70">
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Akun Mahasiswa</p>
                                        <p class="text-xs font-bold text-gray-900 truncate mt-0.5">{{ Auth::user()->name }}</p>
                                        <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <span class="inline-flex items-center text-[10px] font-bold text-emerald-800 bg-emerald-100/80 px-2 py-0.5 rounded-md">
                                                {{ Auth::user()->study_program ?? 'Program Studi' }} &bull; Smt {{ Auth::user()->semester ?? 1 }}
                                            </span>
                                            @if(Auth::user()->nim)
                                                <span class="inline-flex items-center text-[10px] font-semibold text-gray-600 bg-gray-200/80 px-2 py-0.5 rounded-md">
                                                    NIM: {{ Auth::user()->nim }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-1.5 space-y-0.5">
                                        <a href="{{ route('items.my') }}" 
                                           class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 rounded-xl flex items-center justify-between transition-colors">
                                            <div class="flex items-center space-x-2">
                                                <x-icon name="package" class="w-4 h-4 text-emerald-700" />
                                                <span>Barang Saya</span>
                                            </div>
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-gray-400" />
                                        </a>

                                        <a href="{{ route('claims.incoming') }}" 
                                           class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 rounded-xl flex items-center justify-between transition-colors">
                                            <div class="flex items-center space-x-2">
                                                <x-icon name="inbox" class="w-4 h-4 text-emerald-700" />
                                                <span>Pengajuan Masuk</span>
                                            </div>
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-gray-400" />
                                        </a>

                                        <a href="{{ route('claims.my') }}" 
                                           class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 rounded-xl flex items-center justify-between transition-colors">
                                            <div class="flex items-center space-x-2">
                                                <x-icon name="clock" class="w-4 h-4 text-emerald-700" />
                                                <span>Pengajuan Saya</span>
                                            </div>
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-gray-400" />
                                        </a>

                                        <a href="{{ route('profile.edit') }}" 
                                           class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 rounded-xl flex items-center justify-between transition-colors">
                                            <div class="flex items-center space-x-2">
                                                <x-icon name="settings" class="w-4 h-4 text-gray-500" />
                                                <span>Pengaturan Profil</span>
                                            </div>
                                            <x-icon name="chevron-right" class="w-3.5 h-3.5 text-gray-400" />
                                        </a>
                                    </div>

                                    <div class="p-1.5">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full text-left px-3.5 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl flex items-center space-x-2.5 transition-colors cursor-pointer">
                                                <x-icon name="log-out" class="w-4 h-4 text-rose-600" />
                                                <span>Keluar Sesi</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Mode (Sign in equivalent) -->
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center space-x-1 text-xs font-bold text-gray-700 hover:text-emerald-800 px-3 py-2 rounded-lg transition-colors">
                            <x-icon name="user" class="w-4 h-4 text-gray-500" />
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center space-x-1.5 text-xs font-bold text-white bg-emerald-800 hover:bg-emerald-900 px-4 py-2 rounded-full transition-colors shadow-2xs">
                            <span>Daftar Sekarang</span>
                            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                        </a>
                    @endauth
                </div>

                <!-- Hamburger Mobile Toggle -->
                <div class="flex items-center md:hidden">
                    <button type="button"
                            @click="open = !open" 
                            aria-label="Buka Menu Navigasi"
                            class="p-2 rounded-xl text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 cursor-pointer">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. Bottom Tier: Location / Campus Node Indicator & Main Search Bar (Sesuai Persis Baris Kedua Shopee) -->
    <div class="py-3 hidden md:block bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-6">
                
                <!-- Deliver to equivalent: Node Kampus Terbuka -->
                <div class="flex items-center space-x-2 text-xs font-semibold text-gray-700 shrink-0">
                    <x-icon name="map-pin" class="w-4 h-4 text-emerald-700" />
                    <span>Node Kampus Terbuka</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Zona A
                    </span>
                </div>

                <!-- Center Search Input Bar (Tampilan Shopee: Lebar, Rounded, Placeholder Jelas) -->
                <div class="flex-1 max-w-2xl">
                    <form action="{{ route('items.index') }}" method="GET" class="w-full">
                        <div class="relative flex items-center w-full bg-[#f6f6f6] hover:bg-[#f0f0f0] focus-within:bg-white rounded-full border border-gray-200 focus-within:border-emerald-700 focus-within:ring-2 focus-within:ring-emerald-700/20 transition-all p-1">
                            <span class="pl-3.5 pr-2 text-gray-400">
                                <x-icon name="search" class="w-4 h-4 text-gray-400" />
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari buku kalkulus, jas lab, kemeja sidang, kalkulator..."
                                   class="w-full py-1.5 text-xs text-gray-900 placeholder-gray-400 bg-transparent border-0 focus:ring-0 focus:outline-none">
                            <button type="submit" 
                                    class="px-5 py-1.5 bg-emerald-800 hover:bg-emerald-900 active:bg-emerald-950 text-white font-bold text-xs rounded-full transition-colors shrink-0 flex items-center space-x-1.5 cursor-pointer shadow-2xs">
                                <span>Cari</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5 text-white" />
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Verified Status -->
                <div class="flex items-center space-x-2 text-xs text-gray-500 shrink-0">
                    <x-icon name="lock" class="w-3.5 h-3.5 text-emerald-700" />
                    <span class="font-medium">Civitas Akademika</span>
                </div>

            </div>
        </div>
    </div>

    <!-- Mobile Search Bar (Tampil di Layar HP) -->
    <div class="p-3 md:hidden border-t border-gray-100 bg-white">
        <form action="{{ route('items.index') }}" method="GET" class="w-full">
            <div class="relative flex items-center w-full bg-[#f6f6f6] rounded-full border border-gray-200 focus-within:bg-white focus-within:border-emerald-700 transition-all p-1">
                <span class="pl-3 pr-2 text-gray-400">
                    <x-icon name="search" class="w-4 h-4 text-gray-400" />
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari buku, kalkulator, jas lab..."
                       class="w-full py-1.5 text-xs text-gray-900 placeholder-gray-400 bg-transparent border-0 focus:ring-0 focus:outline-none">
                <button type="submit" 
                        class="px-3.5 py-1.5 bg-emerald-800 text-white font-bold text-xs rounded-full shrink-0">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobileDrawerMenu"
         x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg">
        
        <div class="space-y-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                <x-icon name="package" class="w-4 h-4 text-emerald-800" />
                <span>Beranda</span>
            </a>
            <a href="{{ route('items.index') }}" 
               class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('items.index') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                <x-icon name="search" class="w-4 h-4 text-emerald-800" />
                <span>Jelajahi Katalog</span>
            </a>
            
            @auth
                <a href="{{ route('items.create') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl bg-amber-50 text-amber-900 border border-amber-200/80 font-bold transition-colors">
                    <x-icon name="plus" class="w-4 h-4 text-amber-700" />
                    <span>Pasang Barang</span>
                </a>
                <a href="{{ route('claims.incoming') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <x-icon name="inbox" class="w-4 h-4 text-emerald-700" />
                    <span>Pengajuan Masuk</span>
                </a>
                <a href="{{ route('items.my') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <x-icon name="package" class="w-4 h-4 text-emerald-700" />
                    <span>Barang Saya</span>
                </a>
                <a href="{{ route('claims.my') }}" 
                   class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <x-icon name="clock" class="w-4 h-4 text-amber-600" />
                    <span>Pengajuan Saya</span>
                </a>

                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-2.5 px-3.5 py-3 rounded-xl text-amber-900 bg-amber-50 hover:bg-amber-100 border border-amber-200 font-bold transition-colors">
                        <x-icon name="shield" class="w-4 h-4 text-amber-700" />
                        <span>Portal Moderasi Admin</span>
                    </a>
                @endif
            @endauth
        </div>

        <div class="border-t border-gray-100 pt-3 mt-2">
            @auth
                <div class="flex items-center space-x-3 px-3 py-2.5 bg-gray-50 rounded-2xl mb-2">
                    <img class="w-10 h-10 rounded-full object-cover border border-emerald-700/20 shrink-0" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                         referrerpolicy="no-referrer"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=144d37&color=ffffff';"
                         alt="{{ Auth::user()->name }}">
                    <div class="truncate">
                        <div class="font-bold text-gray-900 text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-emerald-700 truncate">{{ Auth::user()->study_program ?? Auth::user()->faculty ?? 'Mahasiswa Kampus' }} &bull; Semester {{ Auth::user()->semester ?? 1 }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center space-x-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-gray-700 hover:bg-gray-50">
                        <x-icon name="settings" class="w-4 h-4 text-gray-500" />
                        <span>Pengaturan Profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center space-x-2">
                            <x-icon name="log-out" class="w-4 h-4 text-rose-600" />
                            <span>Keluar Sesi</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('login') }}" 
                       class="w-full text-center py-3 text-xs font-bold text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                       class="w-full text-center py-3 text-xs font-bold text-white bg-emerald-800 rounded-xl hover:bg-emerald-900">
                        Daftar Akun
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>