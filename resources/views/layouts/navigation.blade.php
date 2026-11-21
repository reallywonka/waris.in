<nav x-data="{ open: false, userDropdown: false }" class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- 1. Sisi Kiri: Brand Logo & Menu Navigasi Utama -->
            <div class="flex items-center space-x-8">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 group focus:outline-none">
                    <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in" class="w-9 h-9 object-contain group-hover:scale-105 transition-transform duration-200">
                    <span class="text-2xl font-black tracking-tight text-gray-900">
                        waris<span class="text-emerald-700">.in</span>
                    </span>
                </a>

                <!-- Menu Navigasi Desktop -->
                <div class="hidden md:flex items-center space-x-1.5 text-sm font-medium">
                    <!-- Beranda -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-2xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    <!-- Jelajahi Katalog -->
                    <a href="{{ route('items.index') }}" 
                       class="px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('items.index') ? 'bg-emerald-50 text-emerald-800 font-bold shadow-2xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Jelajahi Katalog
                    </a>

                    @auth
                        <!-- Pasang Barang (CTA Button) -->
                        <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                           class="inline-flex items-center space-x-1 px-3.5 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('items.create') ? 'bg-emerald-800 text-white font-bold' : 'text-emerald-800 hover:bg-emerald-50 font-bold' }}">
                            <span>+</span>
                            <span>Pasang Barang</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- 2. Sisi Kanan: Akun Mahasiswa / Tombol Masuk Desktop -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <!-- Pill Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" 
                                class="flex items-center space-x-3 p-1.5 pe-4 bg-gray-50 hover:bg-emerald-50/70 border border-gray-200/80 hover:border-emerald-300 rounded-full transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700">
                            <!-- Avatar -->
                            <img class="w-8 h-8 rounded-full object-cover border border-emerald-700/20" 
                                 src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                                 alt="{{ Auth::user()->name }}">
                            
                            <!-- Nama & Fakultas -->
                            <div class="text-left text-xs">
                                <div class="font-bold text-gray-900 leading-tight truncate max-w-36">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-emerald-700 font-medium text-[10px] truncate max-w-36">
                                    {{ Auth::user()->role === 'admin' ? 'Admin Kampus' : (Auth::user()->faculty ?? 'Mahasiswa') }}
                                </div>
                            </div>

                            <!-- Panah Bawah -->
                            <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" 
                                 :class="userDropdown ? 'rotate-180 text-emerald-700' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Menu Dropdown -->
                        <div x-show="userDropdown"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:exit="transition ease-in duration-100"
                             x-transition:exit-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:exit-end="transform opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 divide-y divide-gray-100"
                             style="display: none;">
                            
                            <!-- Ringkasan Info Mahasiswa -->
                            <div class="px-4 py-3 bg-gray-50/50">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Akun Mahasiswa</p>
                                <p class="text-xs font-bold text-gray-900 truncate mt-0.5">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                @if(Auth::user()->nim)
                                    <span class="inline-flex items-center text-[10px] font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md mt-1.5">
                                        NIM: {{ Auth::user()->nim }}
                                    </span>
                                @endif
                            </div>

                            <!-- Menu Utama Mahasiswa -->
                            <div class="py-1.5 text-xs font-medium">
                                <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" 
                                   class="flex items-center justify-between px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition-colors">
                                    <span class="flex items-center space-x-2">
                                        <span>📥</span>
                                        <span>Pengajuan Masuk</span>
                                    </span>
                                </a>

                                <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                                   class="flex items-center justify-between px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition-colors">
                                    <span class="flex items-center space-x-2">
                                        <span>📦</span>
                                        <span>Barang Saya</span>
                                    </span>
                                </a>

                                <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" 
                                   class="flex items-center justify-between px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition-colors">
                                    <span class="flex items-center space-x-2">
                                        <span>⏳</span>
                                        <span>Pengajuan Saya</span>
                                    </span>
                                </a>
                            </div>

                            <!-- Menu Pengaturan & Admin -->
                            <div class="py-1.5 text-xs font-medium">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" 
                                       class="flex items-center space-x-2 px-4 py-2 text-amber-800 hover:bg-amber-50 font-bold transition-colors">
                                        <span>🛡️</span>
                                        <span>Portal Moderasi Admin</span>
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 transition-colors">
                                    <span>⚙️</span>
                                    <span>Pengaturan Profil</span>
                                </a>
                            </div>

                            <!-- Logout Sesi -->
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center space-x-2 transition-colors">
                                        <span>🚪</span>
                                        <span>Keluar Sesi</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tombol Masuk & Daftar untuk Tamu -->
                    <a href="{{ route('login') }}" 
                       class="text-xs font-bold text-gray-700 hover:text-emerald-800 px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center space-x-1.5 text-xs font-bold text-white bg-emerald-800 hover:bg-emerald-900 px-4 py-2.5 rounded-xl shadow-xs transition-colors focus-visible:ring-2 focus-visible:ring-emerald-700">
                        <span>Daftar Sekarang</span>
                        <span>&rarr;</span>
                    </a>
                @endauth
            </div>

            <!-- 3. Tombol Hamburger Menu (Mobile & Tablet) -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" 
                        aria-label="Buka Menu Navigasi"
                        class="p-2.5 rounded-xl text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700">
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
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:exit="transition ease-in duration-150"
         x-transition:exit-start="opacity-100 translate-y-0"
         x-transition:exit-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100 bg-white/98 backdrop-blur-md px-4 pt-3 pb-6 space-y-2 shadow-lg"
         style="display: none;">
        
        <div class="space-y-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" 
               class="block px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                🏠 Beranda
            </a>
            <a href="{{ route('items.index') }}" 
               class="block px-3.5 py-3 rounded-xl transition-colors {{ request()->routeIs('items.index') ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                🔍 Jelajahi Katalog
            </a>
            
            @auth
                <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                   class="block px-3.5 py-3 rounded-xl text-emerald-800 font-bold hover:bg-emerald-50 transition-colors">
                    ➕ Pasang Barang Baru
                </a>
                <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" 
                   class="block px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    📥 Pengajuan Masuk
                </a>
                <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                   class="block px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    📦 Barang Saya
                </a>
                <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" 
                   class="block px-3.5 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    ⏳ Pengajuan Saya
                </a>
            @endauth
        </div>

        <div class="border-t border-gray-100 pt-3 mt-2">
            @auth
                <div class="flex items-center space-x-3 px-3 py-2.5 bg-gray-50 rounded-2xl mb-2">
                    <img class="w-10 h-10 rounded-full object-cover border border-emerald-700/20 shrink-0" 
                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                         alt="{{ Auth::user()->name }}">
                    <div class="truncate">
                        <div class="font-bold text-gray-900 text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-emerald-700 truncate">{{ Auth::user()->faculty ?? 'Mahasiswa Kampus' }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-3.5 py-2.5 rounded-xl text-xs font-semibold text-gray-700 hover:bg-gray-50">
                        ⚙️ Pengaturan Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 flex items-center space-x-2">
                            <span>🚪</span>
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
                       class="w-full text-center py-3 text-xs font-bold text-white bg-emerald-800 rounded-xl shadow-xs hover:bg-emerald-900">
                        Daftar Akun
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
