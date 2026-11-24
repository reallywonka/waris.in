<x-guest-layout>
    <div class="w-full bg-waris-surface rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-waris-primary/10 max-h-[92vh]">
        
        <!-- Sisi Kiri: Banner Komunitas Hijau -->
        <div class="md:col-span-5 bg-waris-primary-soft/80 p-6 lg:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-waris-border">
            <div>
                <h2 class="mt-2 text-xl lg:text-2xl font-bold text-waris-text leading-snug">
                    Ekosistem estafet barang kampus termudah.
                </h2>
                <p class="mt-2 text-xs text-waris-muted leading-relaxed">
                    Hibahkan buku, perlengkapan kos, atau barter alat praktikum langsung ke sesama mahasiswa tanpa perantara.
                </p>

                <!-- Keunggulan -->
                <div class="mt-6 space-y-3">
                    <div class="bg-waris-surface rounded-2xl p-3.5 border border-waris-border shadow-2xs flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-waris-primary-soft text-waris-primary flex items-center justify-center shrink-0">
                            <x-icon name="users" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-waris-text">Sesama Mahasiswa</h4>
                            <p class="text-[11px] text-waris-subtle">Terhubung langsung antar fakultas untuk saling oper barang kuliah.</p>
                        </div>
                    </div>

                    <div class="bg-waris-surface rounded-2xl p-3.5 border border-waris-border shadow-2xs flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-waris-accent-soft text-waris-accent flex items-center justify-center shrink-0">
                            <x-icon name="shield" class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-waris-text">Bebas Akses Email Pribadi</h4>
                            <p class="text-[11px] text-waris-subtle">Daftar cukup dengan email aktif biasa (Gmail, dsb.) plus NIM.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-waris-primary/10 text-[11px] text-waris-subtle">
                waris.in &mdash; Estafet Barang Kampus
            </div>
        </div>

        <!-- Sisi Kanan: Form Registrasi -->
        <div class="md:col-span-7 p-6 lg:p-8 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Brand & Judul -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/letter-w_g.png') }}" alt="waris.in logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-bold tracking-tight text-waris-text">waris<span class="text-waris-primary">.in</span></span>
                    </div>
                    <span class="inline-flex items-center text-[11px] font-semibold text-waris-primary bg-waris-primary-soft px-2.5 py-0.5 rounded-full border border-waris-primary-border">
                        <x-icon name="zap" class="w-3 h-3 text-waris-primary-muted me-1" />
                        <span>Registrasi Cepat</span>
                    </span>
                </div>

                <div class="mt-3">
                    <h3 class="text-lg lg:text-xl font-bold text-waris-text">Gabung di waris.in!</h3>
                    <p class="text-xs text-waris-subtle">Mulai berbagi dan temukan barang bermanfaat di sekitarmu.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="mt-3.5 space-y-2.5">
                    @csrf

                    <!-- Baris 1: Nama Lengkap & NIM -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">Nama Lengkap <span class="text-waris-danger">*</span></label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                   placeholder="Andi Pratama"
                                   class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                            <x-input-error :messages="$errors->get('name')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="nim" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">NIM Mahasiswa <span class="text-waris-danger">*</span></label>
                            <input id="nim" type="text" name="nim" :value="old('nim')" required
                                   placeholder="13521098"
                                   class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                            <x-input-error :messages="$errors->get('nim')" class="mt-0.5 text-[10px]" />
                        </div>
                    </div>

                    <!-- Baris: Program Studi & Semester -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <div class="sm:col-span-2">
                            <label for="study_program" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">Program Studi / Jurusan <span class="text-waris-danger">*</span></label>
                            <input id="study_program" type="text" name="study_program" :value="old('study_program')" required
                                   placeholder="Contoh: Farmasi, Teknik Informatika"
                                   class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                            <x-input-error :messages="$errors->get('study_program')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="semester" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">Semester <span class="text-waris-danger">*</span></label>
                            <select id="semester" name="semester" required
                                    class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
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
                            <label for="email" class="block text-xs font-semibold text-waris-text-secondary">Email Pribadi <span class="text-waris-danger">*</span></label>
                            <span class="text-[11px] text-waris-faint">Tidak perlu email kampus</span>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               placeholder="nama@gmail.com"
                               class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                        <x-input-error :messages="$errors->get('email')" class="mt-0.5 text-[10px]" />
                    </div>

                    <!-- Baris 2: Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">Password <span class="text-waris-danger">*</span></label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                            <x-input-error :messages="$errors->get('password')" class="mt-0.5 text-[10px]" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-waris-text-secondary mb-0.5">Konfirmasi Password <span class="text-waris-danger">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary py-2 px-3 bg-waris-surface-hover text-waris-text">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-0.5 text-[10px]" />
                        </div>
                    </div>

                    <!-- Checkbox Etika -->
                    <div class="pt-1">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" required class="mt-0.5 rounded border-waris-border-strong text-waris-primary shadow-xs focus:ring-waris-primary cursor-pointer">
                            <span class="ms-2 text-[11px] text-waris-muted leading-tight">
                                Saya menyetujui komitmen etika komunitas mahasiswa dalam berbagi barang secara bertanggung jawab.
                            </span>
                        </label>
                    </div>

                    <!-- Tombol Daftar (Signature Hover: Emerald -> Marigold) -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-waris-primary hover:bg-waris-accent active:bg-waris-accent-hover text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition-colors duration-200 flex items-center justify-center space-x-2 cursor-pointer">
                        <span>Daftar Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </button>
                </form>
            </div>

            <!-- Link Masuk -->
            <div class="mt-3 pt-2.5 border-t border-waris-surface-muted text-center">
                <a href="{{ route('login') }}" class="inline-block w-full py-2 px-4 bg-waris-primary-soft hover:bg-waris-primary-border/40 text-waris-primary font-semibold text-xs rounded-xl transition-colors">
                    Sudah punya akun? <span class="font-bold underline">Masuk di sini</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
