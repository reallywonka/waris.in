<x-guest-layout>
    <div class="w-full bg-waris-surface rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-waris-primary/10 max-h-[92vh]">
        
        <!-- Sisi Kiri: Ringkasan Platform -->
        <div class="md:col-span-5 bg-waris-primary-soft/80 p-6 lg:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-waris-border">
            <div>
                <h2 class="mt-2 text-xl lg:text-2xl font-bold text-waris-text leading-snug">
                    Warisan barang kuliah antar sesama mahasiswa.
                </h2>
                <p class="mt-2.5 text-xs text-waris-muted leading-relaxed">
                    Dari buku ajar, alat praktikum, sampai perlengkapan kos yang sudah tidak terpakai — oper ke adik tingkat atau teman yang membutuhkan.
                </p>

                <!-- Alur Singkat -->
                <div class="mt-6 space-y-3">
                    <div class="bg-waris-surface rounded-2xl p-3.5 border border-waris-border shadow-2xs flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-waris-primary-soft text-waris-primary flex items-center justify-center shrink-0">
                            <x-icon name="package" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-waris-text">Tawarkan dengan 3 Pilihan</h4>
                            <p class="text-[11px] text-waris-subtle mt-0.5 leading-relaxed">Bisa dihibahkan gratis, dijual harga pas mahasiswa, atau dibarter.</p>
                        </div>
                    </div>

                    <div class="bg-waris-surface rounded-2xl p-3.5 border border-waris-border shadow-2xs flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-waris-accent-soft text-waris-accent flex items-center justify-center shrink-0">
                            <x-icon name="check-circle" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-waris-text">Pilih Peminat Tanpa Ribet</h4>
                            <p class="text-[11px] text-waris-subtle mt-0.5 leading-relaxed">Setujui satu pengajuan terbaik, barang otomatis terkunci dari yang lain.</p>
                        </div>
                    </div>

                    <div class="bg-waris-surface rounded-2xl p-3.5 border border-waris-border shadow-2xs flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-waris-barter-soft text-waris-barter flex items-center justify-center shrink-0">
                            <x-icon name="map-pin" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-waris-text">COD Langsung di Area Kampus</h4>
                            <p class="text-[11px] text-waris-subtle mt-0.5 leading-relaxed">Kontak WhatsApp terbuka setelah disetujui agar serah terima aman.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-waris-primary/10 text-[11px] text-waris-subtle">
                waris.in &mdash; Estafet Barang Kampus
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="md:col-span-7 p-6 lg:p-8 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Brand & Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-bold tracking-tight text-waris-text">waris<span class="text-waris-primary">.in</span></span>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg lg:text-xl font-bold text-waris-text">Hai, selamat datang!</h3>
                    <p class="text-xs text-waris-subtle mt-0.5">Masuk dan temukan barang yang mungkin kamu butuhkan.</p>
                </div>

                <!-- Session Status / Errors -->
                <x-auth-session-status class="mt-3 text-xs" :status="session('status')" />
                @if ($errors->any())
                    <div class="mt-3 p-2.5 rounded-xl bg-waris-danger-soft text-waris-danger-text border border-waris-danger-border text-xs font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-3.5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-waris-text-secondary mb-1">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                               placeholder="andi.pratama@gmail.com"
                               class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2.5 px-3.5 bg-waris-surface-hover text-waris-text">
                    </div>

                    <!-- Kata Sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-semibold text-waris-text-secondary">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-medium text-waris-primary-muted hover:underline">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2.5 px-3.5 bg-waris-surface-hover text-waris-text">
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center pt-0.5">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" 
                                   class="rounded border-waris-border-strong text-waris-primary shadow-xs focus:ring-waris-primary cursor-pointer">
                            <span class="ms-2 text-xs text-waris-muted">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Tombol Masuk (Signature Hover: Emerald -> Marigold) -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-waris-primary hover:bg-waris-accent active:bg-waris-accent-hover text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors duration-200 flex items-center justify-center space-x-2 cursor-pointer">
                        <span>Masuk Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </button>
                </form>
            </div>

            <!-- Link Daftar -->
            <div class="mt-4 pt-3 border-t border-waris-surface-muted text-center text-xs text-waris-muted">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-waris-primary hover:underline">
                    Daftar sekarang.
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
