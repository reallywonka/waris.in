<footer class="bg-waris-surface border-t border-waris-border mt-auto">
    <!-- 1. Service / Trust Strip -->
    <div class="border-b border-waris-surface-muted py-6 sm:py-8 bg-waris-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-waris-surface border border-waris-border text-waris-primary flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="truck" class="w-5 h-5 text-waris-primary" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-waris-text">Tanpa Biaya Tambahan</h4>
                        <p class="text-xs text-waris-subtle mt-0.5 leading-relaxed">100% pertukaran mandiri langsung antar mahasiswa kampus tanpa potongan komisi.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-waris-surface border border-waris-border text-waris-barter flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="repeat" class="w-5 h-5 text-waris-barter" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-waris-text">Serah Terima Langsung</h4>
                        <p class="text-xs text-waris-subtle mt-0.5 leading-relaxed">COD di area kampus, periksa kondisi barang secara langsung sebelum deal.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-waris-surface border border-waris-border text-waris-accent flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="message-circle" class="w-5 h-5 text-waris-accent" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-waris-text">Komunitas Terbuka</h4>
                        <p class="text-xs text-waris-subtle mt-0.5 leading-relaxed">Saling bantu kebutuhan kuliah dari angkatan ke angkatan dengan aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Footer Multi-Column Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Kolom Brand & Tagline -->
            <div class="md:col-span-5 space-y-4">
                <div class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/logo-symbol.svg') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                    <span class="text-xl font-bold tracking-tight text-waris-text">
                        waris<span class="text-waris-primary">.in</span>
                    </span>
                </div>
                <p class="text-xs text-waris-muted leading-relaxed max-w-sm">
                    Oper barang kuliah yang sudah beres kamu pakai. Dari buku kuliah, alat laboratorium, sampai perlengkapan kos. Lebih hemat dan tepat guna.
                </p>
                <div class="pt-1 flex items-center space-x-2 text-xs font-semibold text-waris-primary">
                    <span class="w-2 h-2 rounded-full bg-waris-primary-muted animate-pulse"></span>
                    <span>Platform Mahasiswa &bull; Estafet Barang Kampus</span>
                </div>
            </div>

            <!-- Kolom Navigasi Cepat -->
            <div class="md:col-span-3 space-y-3.5">
                <h5 class="text-xs font-bold uppercase tracking-wider text-waris-text">Jelajahi</h5>
                <ul class="space-y-2.5 text-xs text-waris-muted font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('items.index') }}" class="hover:text-waris-primary transition-colors">Jelajahi Katalog</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('items.my') }}" class="hover:text-waris-primary transition-colors">Barang Saya</a>
                        </li>
                        <li>
                            <a href="{{ route('items.create') }}" class="hover:text-waris-primary transition-colors">Pasang Barang Baru</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-waris-primary transition-colors">Masuk Akun</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-waris-primary transition-colors">Daftar Sekarang</a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Kolom Mode Transaksi -->
            <div class="md:col-span-4 space-y-3.5">
                <h5 class="text-xs font-bold uppercase tracking-wider text-waris-text">Mode Transaksi</h5>
                <ul class="space-y-2.5 text-xs text-waris-muted font-medium">
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'gratis']) }}" class="hover:text-waris-primary transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-waris-primary-muted"></span>
                            <span>Gratis (Hibah)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" class="hover:text-waris-primary transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-waris-accent"></span>
                            <span>Harga Pas Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'barter']) }}" class="hover:text-waris-primary transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-waris-barter"></span>
                            <span>Barter Barang Kuliah</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- 3. Bottom Copyright Row -->
        <div class="mt-10 pt-6 border-t border-waris-surface-muted flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-waris-faint">
            <div>
                &copy; {{ date('Y') }} waris.in. Hak Cipta Dilindungi.
            </div>
            <div class="flex items-center space-x-4 font-medium">
                <span>Estafet Barang Kampus</span>
            </div>
        </div>
    </div>
</footer>
