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
                        <img src="{{ asset('images/logo-symbol.svg') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
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

                @if (session('error'))
                    <div class="mt-3 p-3 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-medium flex items-start space-x-2.5">
                        <x-icon name="alert-circle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" />
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-3 p-3 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-medium flex items-start space-x-2.5">
                        <x-icon name="alert-circle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" />
                        <div class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-3.5">
                    @csrf

                    <!-- Email Pribadi / Kampus / NIM -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email Pribadi / Kampus / NIM</label>
                        <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="andi.pratama@gmail.com atau NIM"
                               class="w-full text-xs rounded-xl py-2.5 px-3.5 transition-colors {{ $errors->has('email') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-500' : 'border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50/50' }}">
                        @error('email')
                            <p class="mt-1 text-[11px] text-rose-600 font-medium flex items-center space-x-1">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
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
                               class="w-full text-xs rounded-xl py-2.5 px-3.5 transition-colors {{ $errors->has('password') ? 'border-rose-300 bg-rose-50/20 text-rose-900 focus:border-rose-500 focus:ring-rose-500' : 'border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 bg-gray-50/50' }}">
                        @error('password')
                            <p class="mt-1 text-[11px] text-rose-600 font-medium flex items-center space-x-1">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
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
                    <button type="submit" class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 active:bg-emerald-950 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center space-x-2 cursor-pointer">
                        <span>Masuk Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                    </button>
                </form>
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
