<x-guest-layout>
    <div class="w-full bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-emerald-900/10 max-h-[92vh]">
        
        <!-- Sisi Kiri: Edukasi Gerakan Kampus Sirkular -->
        <div class="md:col-span-5 bg-emerald-50/80 p-6 lg:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-emerald-900/10">
            <div>
                <!-- Badge Gerakan -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-800 text-white text-[11px] font-semibold tracking-wide uppercase shadow-2xs">
                    <x-icon name="repeat" class="w-3.5 h-3.5 text-emerald-200" />
                    <span>Gerakan Kampus Sirkular</span>
                </div>

                <h2 class="mt-4 text-xl lg:text-2xl font-black text-gray-900 leading-snug">
                    Warisan barang berharga antar civitas akademika.
                </h2>
                <p class="mt-2 text-xs text-gray-600 leading-relaxed">
                    Dari buku kuliah, alat laboratorium, sampai perlengkapan kos. Lebih hemat, kurangi limbah, pererat silaturahmi.
                </p>

                <!-- Aktivitas Terkini (Ticker Ringkas) -->
                <div class="mt-5 bg-white rounded-2xl p-3.5 shadow-2xs border border-emerald-900/10">
                    <div class="flex items-center justify-between text-[11px] font-semibold text-gray-500 mb-2.5">
                        <span class="flex items-center space-x-1.5 text-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Aktivitas Terkini</span>
                        </span>
                        <span class="bg-gray-100 px-2 py-0.5 rounded text-[10px]">Zona Kampus A</span>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between bg-emerald-50/60 p-2 rounded-xl border border-emerald-100/80">
                            <div class="truncate pr-2">
                                <p class="font-bold text-gray-800 text-[11px] truncate">Kalkulus Edisi 9</p>
                                <p class="text-gray-500 text-[10px]">Dihibahkan oleh Fajar (Teknik)</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-[10px] shrink-0">Gratis</span>
                        </div>

                        <div class="flex items-center justify-between bg-teal-50/60 p-2 rounded-xl border border-teal-100/80">
                            <div class="truncate pr-2">
                                <p class="font-bold text-gray-800 text-[11px] truncate">Kalkulator Saintifik Casio</p>
                                <p class="text-gray-500 text-[10px]">Barter dengan Meja Lipat</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-lg bg-teal-100 text-teal-800 font-bold text-[10px] shrink-0">Barter</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dampak Stat -->
            <div class="mt-6 pt-4 border-t border-emerald-900/10 flex items-center justify-between text-xs font-medium text-gray-600">
                <div>
                    <span class="block text-sm lg:text-base font-black text-emerald-800">Rp 48.2 jt</span>
                    <span class="text-[11px]">dihemat mhs</span>
                </div>
                <div class="text-right">
                    <span class="block text-sm lg:text-base font-black text-teal-700">1,240+ kg</span>
                    <span class="text-[11px]">emisi dicegah</span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login (Satu Pintu Bebas Tab Admin) -->
        <div class="md:col-span-7 p-6 lg:p-8 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Brand & Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-black tracking-tight text-gray-900">waris<span class="text-emerald-700">.in</span></span>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        ● Node Kampus Terbuka
                    </span>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg lg:text-xl font-bold text-gray-900">Hai, selamat datang!</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Masuk dan temukan barang yang mungkin kamu butuhkan.</p>
                </div>

                <!-- Session Status / Errors -->
                <x-auth-session-status class="mt-3 text-xs" :status="session('status')" />
                @if ($errors->any())
                    <div class="mt-3 p-2.5 rounded-xl bg-red-50 text-red-700 text-xs font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-3.5">
                    @csrf

                    <!-- Email Pribadi / Kampus -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email Pribadi / Kampus</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                               placeholder="andi.pratama@gmail.com"
                               class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3.5 bg-gray-50/50">
                    </div>

                    <!-- Kata Sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-semibold text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-medium text-emerald-700 hover:underline">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3.5 bg-gray-50/50">
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center justify-between pt-0.5">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" 
                                   class="rounded border-gray-300 text-emerald-800 shadow-xs focus:ring-emerald-700">
                            <span class="ms-2 text-xs text-gray-600">Ingat saya</span>
                        </label>
                        <span class="text-[11px] text-gray-400 flex items-center space-x-1">
                            <x-icon name="lock" class="w-3 h-3 text-gray-400" />
                            <span>TLS 256-bit</span>
                        </span>
                    </div>

                    <!-- Tombol Masuk -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center space-x-2">
                        <span>Masuk Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-4 text-center">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <span class="relative px-3 bg-white text-[11px] text-gray-400 font-medium">atau masuk dengan</span>
                </div>

                <!-- Tombol Alternatif (Google Akun Saja - Sesuai Ketentuan Bebas Fasilitas Kampus) -->
                <div>
                    <a href="#" class="w-full flex items-center justify-center space-x-2 py-2.5 px-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors text-xs font-semibold text-gray-700 shadow-2xs">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                        <span>Lanjutkan dengan Google Akun</span>
                    </a>
                </div>
            </div>

            <!-- Link Daftar -->
            <div class="mt-4 pt-3 border-t border-gray-100 text-center text-xs text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-emerald-800 hover:underline">
                    Daftar sekarang.
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
