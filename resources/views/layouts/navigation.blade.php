<nav x-data="{ open: false, userDropdown: false }" class="bg-white/95 backdrop-blur-md border-b border-emerald-900/10 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- 1. Sisi Kiri: Brand Logo -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 group">
                    <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in logo" class="w-9 h-9 object-contain group-hover:scale-105 transition-transform">
                    <span class="text-2xl font-black tracking-tight text-gray-900">
                        waris<span class="text-emerald-700">.in</span>
                    </span>
                </a>

                <!-- 2. Menu Navigasi Desktop -->
                <div class="hidden lg:flex items-center space-x-1 text-sm font-medium">
                    <!-- Beranda -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    <!-- Jelajahi Barang -->
                    <a href="{{ Route::has('items.index') ? route('items.index') : '#' }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('items.index') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Jelajahi Barang
                    </a>

                    <!-- Pasang Barang -->
                    <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('items.create') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Pasang Barang
                    </a>

                    <!-- Pengajuan Masuk -->
                    <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('claims.incoming') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Pengajuan Masuk
                    </a>

                    <!-- Pengajuan Saya -->
                    <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('claims.my') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Pengajuan Saya
                    </a>

                    <!-- Barang Saya -->
                    <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" 
                       class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('items.my') ? 'bg-emerald-50 text-emerald-800 font-semibold shadow-xs' : 'text-gray-600 hover:text-emerald-800 hover:bg-gray-50' }}">
                        Barang Saya
                    </a>
                </div>
            </div>

            <!-- 3. Sisi Kanan: Akun Pengguna / Tombol Masuk -->
            <div class="hidden lg:flex items-center space-x-4">
                @auth
                    <!-- Pill Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" 
                                class="flex items-center space-x-3 p-1.5 pe-4 bg-gray-50 hover:bg-emerald-50/60 border border-gray-200/80 hover:border-emerald-200 rounded-full transition-all focus:outline-none">
                            <!-- Avatar -->
                            <img class="w-9 h-9 rounded-full object-cover border border-emerald-700/20 shadow-xs" 
                                 src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                                 alt="{{ Auth::user()->name }}">
                            
                            <!-- Nama & Role -->
                            <div class="text-left text-xs">
                                <div class="font-bold text-gray-800 leading-tight">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-emerald-700 font-medium text-[11px] capitalize">
                                    {{ Auth::user()->role === 'admin' ? 'Admin Kampus' : 'Mahasiswa' }}
                                </div>
                            </div>

                            <!-- Panah Bawah -->
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                                 :class="userDropdown ? 'rotate-180 text-emerald-700' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Menu Dropdown -->
                        <div x-show="userDropdown"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:exit="transition ease-in duration-75"
                             x-transition:exit-start="transform opacity-100 scale-100"
                             x-transition:exit-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 divide-y divide-gray-100"
                             style="display: none;">
                            
                            <!-- Ringkasan Info User -->
                            <div class="px-4 py-2.5">
                                <p class="text-xs text-gray-400">Masuk sebagai</p>
                                <p class="text-xs font-semibold text-gray-700 truncate">{{ Auth::user()->email }}</p>
                                @if(Auth::user()->nim)
                                    <p class="text-[11px] text-emerald-700 font-medium mt-0.5">NIM: {{ Auth::user()->nim }}</p>
                                @endif
                            </div>

                            <!-- Link Menu -->
                            <div class="py-1">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ Route::has('admin.listings.index') ? route('admin.listings.index') : '#' }}" 
                                       class="flex items-center px-4 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50">
                                        🛡️ Portal Moderasi Admin
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-800">
                                    ⚙️ Pengaturan Profil
                                </a>
                            </div>

                            <!-- Logout -->
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center">
                                        🚪 Keluar Sesi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tombol untuk Pengguna Belum Login -->
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-800 px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-emerald-800 hover:bg-emerald-900 px-4 py-2.5 rounded-xl shadow-xs transition-colors">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>

            <!-- Tombol Hamburger (Mobile) -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="p-2 rounded-xl text-gray-600 hover:text-emerald-800 hover:bg-emerald-50 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Menu Drawer Mobile -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden border-t border-gray-100 bg-white px-4 pt-3 pb-6 space-y-1">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-gray-700' }}">Beranda</a>
        <a href="{{ Route::has('items.index') ? route('items.index') : '#' }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700">Jelajahi Barang</a>
        <a href="{{ Route::has('items.create') ? route('items.create') : '#' }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700">Pasang Barang</a>
        <a href="{{ Route::has('claims.incoming') ? route('claims.incoming') : '#' }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700">Pengajuan Masuk</a>
        <a href="{{ Route::has('claims.my') ? route('claims.my') : '#' }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700">Pengajuan Saya</a>
        <a href="{{ Route::has('items.my') ? route('items.my') : '#' }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700">Barang Saya</a>
        
        <div class="border-t border-gray-100 pt-4 mt-3">
            @auth
                <div class="flex items-center space-x-3 px-3 py-2">
                    <img class="w-10 h-10 rounded-full object-cover" src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="">
                    <div>
                        <div class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50">
                        Keluar Sesi
                    </button>
                </form>
            @else
                <div class="flex flex-col space-y-2 px-3 pt-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 text-sm font-semibold border border-gray-200 rounded-xl">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 text-sm font-semibold text-white bg-emerald-800 rounded-xl">Daftar Sekarang</a>
                </div>
            @endauth
        </div>
    </div>
</nav>