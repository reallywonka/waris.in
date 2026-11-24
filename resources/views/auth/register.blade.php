<x-guest-layout>
    <div class="w-full bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-emerald-900/10 max-h-[92vh]">
        
        <!-- Sisi Kiri: Banner Komunitas Hijau -->
        <div class="md:col-span-5 bg-emerald-50/80 p-6 lg:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-emerald-900/10">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-800 text-white text-[11px] font-semibold tracking-wide uppercase shadow-2xs">
                    <x-icon name="leaf" class="w-3.5 h-3.5 text-emerald-200" />
                    <span>Circular Campus Economy</span>
                </div>

                <h2 class="mt-4 text-xl lg:text-2xl font-black text-gray-900 leading-snug">
                    Ekosistem estafet barang kampus termudah.
                </h2>
                <p class="mt-2 text-xs text-gray-600 leading-relaxed">
                    Dukung gerakan keberlanjutan kampus. Hibahkan buku, perlengkapan kos, atau barter alat praktikum langsung ke sesama mahasiswa tanpa perantara.
                </p>

                <!-- Nilai Tambah Komunitas -->
                <div class="mt-5 space-y-2.5">
                    <div class="bg-white rounded-2xl p-3 border border-emerald-900/10 shadow-2xs flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-base shrink-0">
                            <x-icon name="users" class="w-4 h-4 text-emerald-800" />
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900">3.800+ Mahasiswa</h4>
                            <p class="text-[10px] text-gray-500">Sudah saling mewariskan barang kos & alat studi.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-3 border border-emerald-900/10 shadow-2xs flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-base shrink-0">
                            <x-icon name="shield" class="w-4 h-4 text-amber-800" />
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-gray-900">Bebas Akses Akun Pribadi</h4>
                            <p class="text-[10px] text-gray-500">Daftar cukup dengan email aktif biasa (Gmail, dsb.).</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-emerald-900/10 text-[11px] text-gray-500 flex items-center space-x-1.5">
                <x-icon name="leaf" class="w-3.5 h-3.5 text-emerald-700" />
                <span>waris.in &copy; Komunitas Hijau Kampus Mahasiswa</span>
            </div>
        </div>

        <!-- Sisi Kanan: Form Registrasi Ringkas & Pas di Layar -->
        <div class="md:col-span-7 p-6 lg:p-8 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Brand & Judul -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-symbol.svg') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-black tracking-tight text-gray-900">waris<span class="text-emerald-700">.in</span></span>
                    </div>
                    <span class="inline-flex items-center text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        <x-icon name="zap" class="w-3 h-3 text-emerald-700 me-1" />
                        <span>Registrasi Cepat</span>
                    </span>
                </div>

                <div class="mt-3">
                    <h3 class="text-lg lg:text-xl font-bold text-gray-900">Gabung di waris.in!</h3>
                    <p class="text-xs text-gray-500">Mulai berbagi dan temukan barang bermanfaat di sekitarmu.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="mt-3.5 space-y-2.5">
                    @csrf

                    <!-- Baris 1: Nama Lengkap & NIM -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div>
                            <label for="name" class="block text-[11px] font-semibold text-gray-700 mb-0.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                   placeholder="Andi Pratama"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('name')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="nim" class="block text-[11px] font-semibold text-gray-700 mb-0.5">NIM Mahasiswa <span class="text-red-500">*</span></label>
                            <input id="nim" type="text" name="nim" :value="old('nim')" required
                                   placeholder="13521098"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('nim')" class="mt-0.5 text-[10px]" />
                        </div>
                    </div>

                    <!-- Baris: Program Studi & Semester -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <div class="sm:col-span-2">
                            <label for="study_program" class="block text-[11px] font-semibold text-gray-700 mb-0.5">Program Studi / Jurusan <span class="text-red-500">*</span></label>
                            <input id="study_program" type="text" name="study_program" :value="old('study_program')" required
                                   placeholder="Contoh: Farmasi, Teknik Informatika"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('study_program')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="semester" class="block text-[11px] font-semibold text-gray-700 mb-0.5">Semester <span class="text-red-500">*</span></label>
                            <select id="semester" name="semester" required
                                    class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('semester', 1) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                                <option value="9" {{ old('semester') >= 9 ? 'selected' : '' }}>Semester 8+</option>
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-0.5 text-[10px]" />
                        </div>
                    </div>

                    <!-- Email Pribadi -->
                    <div>
                        <div class="flex items-center justify-between mb-0.5">
                            <label for="email" class="block text-[11px] font-semibold text-gray-700">Email Pribadi <span class="text-red-500">*</span></label>
                            <span class="text-[10px] text-gray-400">Tidak perlu email kampus</span>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               placeholder="nama@gmail.com"
                               class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                        <x-input-error :messages="$errors->get('email')" class="mt-0.5 text-[10px]" />
                    </div>

                    <!-- Baris 2: Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div>
                            <label for="password" class="block text-[11px] font-semibold text-gray-700 mb-0.5">Password <span class="text-red-500">*</span></label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('password')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-semibold text-gray-700 mb-0.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-2 px-3 bg-gray-50/50">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-0.5 text-[10px]" />
                        </div>
                    </div>

                    <!-- Checkbox Etika -->
                    <div class="pt-1">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" required class="mt-0.5 rounded border-gray-300 text-emerald-800 shadow-xs focus:ring-emerald-700">
                            <span class="ms-2 text-[11px] text-gray-600 leading-tight">
                                Saya menyetujui komitmen etika komunitas mahasiswa dalam berbagi barang secara bertanggung jawab.
                            </span>
                        </label>
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center space-x-2">
                        <span>Daftar Sekarang</span>
                        <span>&rarr;</span>
                    </button>
                </form>
            </div>

            <!-- Link Masuk -->
            <div class="mt-3 pt-2.5 border-t border-gray-100 text-center">
                <a href="{{ route('login') }}" class="inline-block w-full py-2 px-4 bg-emerald-50/80 hover:bg-emerald-100/70 text-emerald-900 font-semibold text-xs rounded-xl transition-colors">
                    Sudah punya akun? <span class="font-bold underline">Masuk di sini</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
