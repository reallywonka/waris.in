<x-app-layout>
    <div x-data="{
            mode: '{{ old('mode', $item->mode) }}',
            price: '{{ old('price', $item->price) }}',
            title: '{{ old('title', $item->title) }}',
            category: '{{ old('category', $item->category) }}',
            condition: '{{ old('condition', $item->condition) }}',
         }"
         class="max-w-4xl mx-auto space-y-8 pb-16">

        <!-- 1. Header Halaman -->
        <div class="flex items-center justify-between pb-4 border-b border-waris-border">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-waris-subtle mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-waris-primary transition-colors">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('items.my') }}" class="hover:text-waris-primary transition-colors">Barang Saya</a>
                    <span>/</span>
                    <span class="text-waris-text font-bold">Edit Barang</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-bold text-waris-text tracking-tight">
                    Edit Rincian Barang
                </h1>
                <p class="text-xs sm:text-sm text-waris-subtle mt-0.5">
                    Perbarui informasi atau rencana titik temu COD untuk barang #WARIS-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}.
                </p>
            </div>

            <a href="{{ route('items.my') }}" 
               class="inline-flex items-center space-x-1 px-3.5 py-2 rounded-xl border border-waris-border bg-waris-surface hover:bg-waris-surface-hover text-xs font-bold text-waris-text-secondary transition-colors shadow-2xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5" />
                <span>Kembali</span>
            </a>
        </div>

        <!-- 2. Formulir Edit Barang -->
        <form method="POST" action="{{ route('items.update', $item) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Data Utama Barang -->
            <div class="bg-waris-surface rounded-3xl p-6 sm:p-7 border border-waris-border shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-waris-text pb-2 border-b border-waris-surface-muted">
                    <x-icon name="package" class="w-4 h-4 text-waris-primary" />
                    <span>Informasi Pokok Barang</span>
                </div>

                <!-- Judul Barang -->
                <div>
                    <label for="title" class="block text-xs font-bold text-waris-text-secondary mb-1">
                        Judul Barang <span class="text-waris-danger">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           x-model="title"
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                    @error('title')
                        <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-xs font-bold text-waris-text-secondary mb-1">
                            Kategori Barang <span class="text-waris-danger">*</span>
                        </label>
                        <select id="category" 
                                name="category" 
                                required
                                x-model="category"
                                class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $item->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label for="condition" class="block text-xs font-bold text-waris-text-secondary mb-1">
                            Kondisi Fisik <span class="text-waris-danger">*</span>
                        </label>
                        <select id="condition" 
                                name="condition" 
                                required
                                x-model="condition"
                                class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                            @foreach ($conditions as $condKey => $condDesc)
                                <option value="{{ $condKey }}" {{ old('condition', $item->condition) === $condKey ? 'selected' : '' }}>
                                    {{ $condKey }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Kondisi (Kejujuran Fisik) -->
                <div>
                    <label for="condition_note" class="block text-xs font-bold text-waris-text-secondary mb-1">
                        Catatan Kejujuran Kondisi (Opsional)
                    </label>
                    <input type="text" 
                           id="condition_note" 
                           name="condition_note" 
                           value="{{ old('condition_note', $item->condition_note) }}"
                           placeholder="Contoh: Ada baret halus di sisi pojok kiri, baterai masih sangat awet..."
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <label for="description" class="block text-xs font-bold text-waris-text-secondary mb-1">
                        Deskripsi Lengkap Barang <span class="text-waris-danger">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              required
                              class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian 2: Format Transaksi -->
            <div class="bg-waris-surface rounded-3xl p-6 sm:p-7 border border-waris-border shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-waris-text pb-2 border-b border-waris-surface-muted">
                    <x-icon name="tag" class="w-4 h-4 text-waris-primary" />
                    <span>Format Transaksi Mahasiswa</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'gratis' ? 'border-waris-primary bg-waris-primary-soft/50' : 'border-waris-border hover:border-waris-border-strong bg-waris-surface'">
                        <input type="radio" name="mode" value="gratis" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-waris-primary">Hibah / Gratis (Rp 0)</span>
                        <span class="text-[11px] text-waris-subtle mt-1">Diberikan secara cuma-cuma</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'harga_pas' ? 'border-waris-accent bg-waris-accent-soft/50' : 'border-waris-border hover:border-waris-border-strong bg-waris-surface'">
                        <input type="radio" name="mode" value="harga_pas" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-waris-accent-text">Harga Pas (COD)</span>
                        <span class="text-[11px] text-waris-subtle mt-1">Bayar tunai/transfer saat temu</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'barter' ? 'border-waris-barter bg-waris-barter-soft/50' : 'border-waris-border hover:border-waris-border-strong bg-waris-surface'">
                        <input type="radio" name="mode" value="barter" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-waris-barter-text">Mode Barter</span>
                        <span class="text-[11px] text-waris-subtle mt-1">Tukar barang sepadan</span>
                    </label>
                </div>

                <!-- Input Nominal Harga Jika Harga Pas -->
                <div x-show="mode === 'harga_pas'" x-transition class="space-y-1">
                    <label for="price" class="block text-xs font-bold text-waris-text-secondary">
                        Nominal Harga Pas (Rp) <span class="text-waris-danger">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-waris-subtle">Rp</span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               x-model="price"
                               min="0"
                               step="1000"
                               class="w-full text-xs rounded-xl pl-10 border-waris-border focus:border-waris-accent focus:ring-waris-accent shadow-2xs bg-waris-surface text-waris-text">
                    </div>
                    @error('price')
                        <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Ekspektasi Barter -->
                <div x-show="mode === 'barter'" x-transition class="space-y-1">
                    <label for="barter_request" class="block text-xs font-bold text-waris-text-secondary">
                        Barang yang Anda Harapkan Sebagai Penukar <span class="text-waris-danger">*</span>
                    </label>
                    <input type="text" 
                           id="barter_request" 
                           name="barter_request" 
                           value="{{ old('barter_request', $item->barter_request) }}"
                           placeholder="Contoh: Modul praktikum Semester 5 atau Flashdisk 64GB..."
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-barter focus:ring-waris-barter shadow-2xs bg-waris-surface text-waris-text">
                    @error('barter_request')
                        <p class="text-[11px] text-waris-danger mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian 3: Rencana Titik Temu COD Kampus -->
            <div class="bg-waris-surface rounded-3xl p-6 sm:p-7 border border-waris-border shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-waris-text pb-2 border-b border-waris-surface-muted">
                    <x-icon name="map-pin" class="w-4 h-4 text-waris-primary" />
                    <span>Rencana Pertemuan & Kontak COD Kampus</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="meetup_location" class="block text-xs font-bold text-waris-text-secondary mb-1">
                            Titik Lokasi Pertemuan di Kampus
                        </label>
                        <input type="text" 
                               id="meetup_location" 
                               name="meetup_location" 
                               value="{{ old('meetup_location', $item->meetup_location) }}"
                               placeholder="Contoh: Depan Perpustakaan Pusat / Kantin Fasilkom"
                               class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                    </div>

                    <div>
                        <label for="time_handover" class="block text-xs font-bold text-waris-text-secondary mb-1">
                            Waktu Serah Terima Fleksibel
                        </label>
                        <input type="text" 
                               id="time_handover" 
                               name="time_handover" 
                               value="{{ old('time_handover', $item->time_handover) }}"
                               placeholder="Contoh: Hari kerja setelah jam 16.00 WIB"
                               class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                    </div>
                </div>

                <div>
                    <label for="contact_info" class="block text-xs font-bold text-waris-text-secondary mb-1">
                        Nomor WhatsApp / Kontak Anda <span class="text-waris-danger">*</span>
                    </label>
                    <input type="text" 
                           id="contact_info" 
                           name="contact_info" 
                           required
                           value="{{ old('contact_info', $item->contact_info) }}"
                           class="w-full text-xs rounded-xl border-waris-border focus:border-waris-primary focus:ring-waris-primary shadow-2xs bg-waris-surface text-waris-text">
                    <p class="text-[11px] text-waris-faint mt-1">
                        Kontak Anda hanya dibagikan ke peminat yang pengajuannya Anda setujui.
                    </p>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('items.my') }}" 
                   class="px-5 py-3 rounded-2xl border border-waris-border-strong text-xs font-bold text-waris-text-secondary hover:bg-waris-surface-muted transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 rounded-2xl bg-waris-primary hover:bg-waris-primary-hover text-white text-xs font-bold shadow-2xs hover:shadow-xs transition-colors flex items-center space-x-1.5 cursor-pointer">
                    <x-icon name="check" class="w-4 h-4" />
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
