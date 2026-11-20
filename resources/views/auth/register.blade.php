<x-guest-layout>
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-emerald-900/10">
        
        <!-- Sisi Kiri: Banner Komunitas Hijau -->
        <div class="md:col-span-5 bg-gradient-to-br from-emerald-50/80 via-emerald-100/40 to-teal-50/60 p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-emerald-900/10">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-800 text-white text-xs font-semibold tracking-wide uppercase shadow-xs">
                    <span>🌱</span>
                    <span>Circular Campus Economy</span>
                </div>

                <h2 class="mt-6 text-2xl font-black text-gray-900 leading-tight">
                    Ekosistem estafet barang kampus termudah.
                </h2>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Dukung gerakan keberlanjutan kampus. Hibahkan buku, perlengkapan kos, atau barter alat praktikum langsung ke rekan sesama mahasiswa tanpa perantara.
                </p>

                <!-- Nilai Tambah Komunitas -->
                <div class="mt-8 space-y-3">
                    <div class="bg-white/90 backdrop-blur rounded-2xl p-4 border border-emerald-900/10 shadow-xs flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-lg shrink-0">
                            👥
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900">3.800+ Mahasiswa</h4>
                            <p class="text-[11px] text-gray-500">Sudah saling mewariskan barang kos & peralatan studi.</p>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur rounded-2xl p-4 border border-emerald-900/10 shadow-xs flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-lg shrink-0">
                            🛡️
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900">Bebas Akses Akun Pribadi</h4>
                            <p class="text-[11px] text-gray-500">Daftar cukup dengan email aktif biasa (Gmail, dsb.).</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-emerald-900/10 text-xs text-gray-500">
                🌿 waris.in &copy; Komunitas Hijau Kampus Mahasiswa
            </div>
        </div>

        <!-- Sisi Kanan: Form Registrasi -->
        <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <!-- Brand & Judul -->
                <div class="text-center md:text-left">
                    <div class="inline-flex items-center space-x-2">
                        <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-bold tracking-tight text-gray-900">waris<span class="text-emerald-700">.in</span></span>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-gray-900">Gabung di waris.in!</h3>
                    <p class="text-xs text-gray-500 mt-1">Mulai berbagi dan temukan barang bermanfaat di sekitar kampusmu.</p>
                </div>

                <!-- Info Registrasi Cepat -->
                <div class="mt-5 p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-xs text-emerald-900 flex items-start space-x-2.5">
                    <span class="text-sm">ℹ️</span>
                    <div>
                        <span class="font-bold">Registrasi Cepat</span>
                        <p class="text-[11px] text-emerald-800 mt-0.5">Registrasi instan tanpa verifikasi rumit. Akun langsung aktif seketika!</p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                    @csrf

                    <!-- Baris 1: Nama Lengkap & NIM -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                   placeholder="Andi Pratama"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                        </div>
                        <div>
                            <label for="nim" class="block text-xs font-semibold text-gray-700 mb-1">NIM Mahasiswa <span class="text-red-500">*</span></label>
                            <input id="nim" type="text" name="nim" :value="old('nim')" required
                                   placeholder="13521098"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('nim')" class="mt-1 text-xs" />
                        </div>
                    </div>

                    <!-- Email Pribadi -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="email" class="block text-xs font-semibold text-gray-700">Email Pribadi <span class="text-red-500">*</span></label>
                            <span class="text-[11px] text-gray-400">Tidak perlu email kampus</span>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               placeholder="nama@gmail.com"
                               class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <!-- Baris 2: Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                        </div>
                    </div>

                    <p class="text-[11px] text-gray-400">ℹ️ Password minimal 8 karakter</p>

                    <!-- Checkbox Etika -->
                    <div class="pt-2">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" required class="mt-0.5 rounded-md border-gray-300 text-emerald-800 shadow-xs focus:ring-emerald-700">
                            <span class="ms-2.5 text-xs text-gray-600 leading-relaxed">
                                Saya menyetujui komitmen etika komunitas mahasiswa dalam berbagi barang secara bertanggung jawab.
                            </span>
                        </label>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full py-3 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-sm transition-colors flex items-center justify-center space-x-2">
                        <span>Daftar Sekarang</span>
                        <span>&rarr;</span>
                    </button>
                </form>
            </div>

            <!-- Link Masuk -->
            <div class="mt-8 pt-4 border-t border-gray-100 text-center">
                <a href="{{ route('login') }}" class="inline-block w-full py-2.5 px-4 bg-emerald-50/80 hover:bg-emerald-100/70 text-emerald-900 font-semibold text-xs rounded-xl transition-colors">
                    Sudah punya akun? <span class="font-bold underline">Masuk di sini</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>