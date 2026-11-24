<footer class="bg-white border-t border-gray-100 mt-auto">
    <!-- 1. Service / Trust Strip (Sesuai Persis Strip Layanan di Referensi Shopee) -->
    <div class="border-b border-gray-100 py-6 sm:py-8 bg-[#fafaf8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1: Bebas Ongkir / Tanpa Biaya Tambahan (Shipping & Vouchers equivalent) -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-white border border-gray-200/80 text-emerald-800 flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="truck" class="w-5 h-5 text-emerald-800" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-black text-gray-900">Tanpa Biaya Tambahan</h4>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">100% pertukaran mandiri langsung antar mahasiswa kampus tanpa potongan komisi.</p>
                    </div>
                </div>

                <!-- Feature 2: Serah Terima Langsung (Returns & Refunds equivalent) -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-white border border-gray-200/80 text-teal-800 flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="repeat" class="w-5 h-5 text-teal-800" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-black text-gray-900">Serah Terima Langsung</h4>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">COD di area kampus, periksa kondisi barang secara langsung sebelum deal.</p>
                    </div>
                </div>

                <!-- Feature 3: Komunitas Terbuka (Need a Hand equivalent) -->
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-white border border-gray-200/80 text-amber-700 flex items-center justify-center shrink-0 shadow-2xs">
                        <x-icon name="message-circle" class="w-5 h-5 text-amber-700" strokeWidth="1.75" />
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-black text-gray-900">Komunitas Terbuka</h4>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Saling bantu kebutuhan kuliah dari angkatan ke angkatan dengan aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Footer Multi-Column Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Kolom Brand & Tagline -->
            <div class="md:col-span-5 space-y-4">
                <div class="flex items-center space-x-2.5">
                    <img src="{{ asset('images/logo-symbol.svg') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                    <span class="text-xl font-black tracking-tight text-gray-900">
                        waris<span class="text-emerald-700">.in</span>
                    </span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed max-w-sm">
                    Oper barang kuliah yang sudah beres kamu pakai. Dari buku kuliah, alat laboratorium, sampai perlengkapan kos. Lebih hemat, kurangi limbah, pererat silaturahmi.
                </p>
                <div class="pt-1 flex items-center space-x-2 text-xs font-bold text-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Node Kampus Terbuka &bull; Civitas Akademika</span>
                </div>
            </div>

            <!-- Kolom Navigasi Cepat -->
            <div class="md:col-span-3 space-y-3.5">
                <h5 class="text-xs font-bold uppercase tracking-wider text-gray-900">Jelajahi</h5>
                <ul class="space-y-2.5 text-xs text-gray-600 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('items.index') }}" class="hover:text-emerald-800 transition-colors">Jelajahi Katalog</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('items.my') }}" class="hover:text-emerald-800 transition-colors">Barang Saya</a>
                        </li>
                        <li>
                            <a href="{{ route('items.create') }}" class="hover:text-emerald-800 transition-colors">Pasang Barang Baru</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-emerald-800 transition-colors">Masuk Akun</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-emerald-800 transition-colors">Daftar Sekarang</a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Kolom Mode Transaksi -->
            <div class="md:col-span-4 space-y-3.5">
                <h5 class="text-xs font-bold uppercase tracking-wider text-gray-900">Mode Transaksi</h5>
                <ul class="space-y-2.5 text-xs text-gray-600 font-medium">
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'gratis']) }}" class="hover:text-emerald-800 transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Gratis (Hibah)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'harga_pas']) }}" class="hover:text-emerald-800 transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span>Harga Pas Mahasiswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.index', ['mode' => 'barter']) }}" class="hover:text-emerald-800 transition-colors flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                            <span>Barter Barang Kuliah</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- 3. Bottom Copyright Row -->
        <div class="mt-12 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
            <div>
                &copy; {{ date('Y') }} waris.in. Hak Cipta Dilindungi.
            </div>
            <div class="flex items-center space-x-4 font-medium">
                <span>Gerakan Kampus Sirkular</span>
                <span>&bull;</span>
                <span>Estafet Barang Kampus</span>
            </div>
        </div>
    </div>
</footer>