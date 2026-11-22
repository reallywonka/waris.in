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
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('items.my') }}" class="hover:text-emerald-800 transition-colors">Barang Saya</a>
                    <span>/</span>
                    <span class="text-gray-800 font-bold">Edit Barang</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Edit Rincian Barang
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Perbarui informasi atau rencana titik temu COD untuk barang #WARIS-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}.
                </p>
            </div>

            <a href="{{ route('items.my') }}" 
               class="inline-flex items-center space-x-1 px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-xs font-bold text-gray-700 transition-colors shadow-2xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5" />
                <span>Kembali</span>
            </a>
        </div>

        <!-- 2. Formulir Edit Barang -->
        <form method="POST" action="{{ route('items.update', $item) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Data Utama Barang -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">
                    <x-icon name="package" class="w-4 h-4 text-emerald-800" />
                    <span>Informasi Pokok Barang</span>
                </div>

                <!-- Judul Barang -->
                <div>
                    <label for="title" class="block text-xs font-bold text-gray-700 mb-1">
                        Judul Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required
                           x-model="title"
                           class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                    @error('title')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-xs font-bold text-gray-700 mb-1">
                            Kategori Barang <span class="text-rose-500">*</span>
                        </label>
                        <select id="category" 
                                name="category" 
                                required
                                x-model="category"
                                class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $item->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label for="condition" class="block text-xs font-bold text-gray-700 mb-1">
                            Kondisi Fisik <span class="text-rose-500">*</span>
                        </label>
                        <select id="condition" 
                                name="condition" 
                                required
                                x-model="condition"
                                class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                            @foreach ($conditions as $condKey => $condDesc)
                                <option value="{{ $condKey }}" {{ old('condition', $item->condition) === $condKey ? 'selected' : '' }}>
                                    {{ $condKey }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Kondisi (Kejujuran Fisik) -->
                <div>
                    <label for="condition_note" class="block text-xs font-bold text-gray-700 mb-1">
                        Catatan Kejujuran Kondisi (Opsional)
                    </label>
                    <input type="text" 
                           id="condition_note" 
                           name="condition_note" 
                           value="{{ old('condition_note', $item->condition_note) }}"
                           placeholder="Contoh: Ada baret halus di sisi pojok kiri, baterai masih sangat awet..."
                           class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <label for="description" class="block text-xs font-bold text-gray-700 mb-1">
                        Deskripsi Lengkap Barang <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              required
                              class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian 2: Format Transaksi -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">
                    <x-icon name="tag" class="w-4 h-4 text-emerald-800" />
                    <span>Format Transaksi Mahasiswa</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'gratis' ? 'border-emerald-700 bg-emerald-50/50' : 'border-gray-200 hover:border-gray-300 bg-white'">
                        <input type="radio" name="mode" value="gratis" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-emerald-800">Hibah / Gratis (Rp 0)</span>
                        <span class="text-[10px] text-gray-500 mt-1">Diberikan secara cuma-cuma</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'harga_pas' ? 'border-amber-600 bg-amber-50/50' : 'border-gray-200 hover:border-gray-300 bg-white'">
                        <input type="radio" name="mode" value="harga_pas" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-amber-800">Harga Pas (COD)</span>
                        <span class="text-[10px] text-gray-500 mt-1">Bayar tunai/transfer saat temu</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                           :class="mode === 'barter' ? 'border-teal-700 bg-teal-50/50' : 'border-gray-200 hover:border-gray-300 bg-white'">
                        <input type="radio" name="mode" value="barter" x-model="mode" class="sr-only">
                        <span class="text-xs font-bold text-teal-800">Mode Barter</span>
                        <span class="text-[10px] text-gray-500 mt-1">Tukar barang sepadan</span>
                    </label>
                </div>

                <!-- Input Nominal Harga Jika Harga Pas -->
                <div x-show="mode === 'harga_pas'" x-transition class="space-y-1">
                    <label for="price" class="block text-xs font-bold text-gray-700">
                        Nominal Harga Pas (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-gray-500">Rp</span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               x-model="price"
                               min="0"
                               step="1000"
                               class="w-full text-xs rounded-xl pl-10 border-gray-300 focus:border-amber-600 focus:ring-amber-600 shadow-2xs">
                    </div>
                    @error('price')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Ekspektasi Barter -->
                <div x-show="mode === 'barter'" x-transition class="space-y-1">
                    <label for="barter_request" class="block text-xs font-bold text-gray-700">
                        Barang yang Anda Harapkan Sebagai Penukar <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="barter_request" 
                           name="barter_request" 
                           value="{{ old('barter_request', $item->barter_request) }}"
                           placeholder="Contoh: Modul praktikum Semester 5 atau Flashdisk 64GB..."
                           class="w-full text-xs rounded-xl border-gray-300 focus:border-teal-700 focus:ring-teal-700 shadow-2xs">
                    @error('barter_request')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian 3: Rencana Titik Temu COD Kampus -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-5">
                <div class="flex items-center space-x-2 text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">
                    <x-icon name="map-pin" class="w-4 h-4 text-emerald-800" />
                    <span>Rencana Pertemuan & Kontak COD Kampus</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="meetup_location" class="block text-xs font-bold text-gray-700 mb-1">
                            Titik Lokasi Pertemuan di Kampus
                        </label>
                        <input type="text" 
                               id="meetup_location" 
                               name="meetup_location" 
                               value="{{ old('meetup_location', $item->meetup_location) }}"
                               placeholder="Contoh: Depan Perpustakaan Pusat / Kantin Fasilkom"
                               class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                    </div>

                    <div>
                        <label for="time_handover" class="block text-xs font-bold text-gray-700 mb-1">
                            Waktu Serah Terima Fleksibel
                        </label>
                        <input type="text" 
                               id="time_handover" 
                               name="time_handover" 
                               value="{{ old('time_handover', $item->time_handover) }}"
                               placeholder="Contoh: Hari kerja setelah jam 16.00 WIB"
                               class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                    </div>
                </div>

                <div>
                    <label for="contact_info" class="block text-xs font-bold text-gray-700 mb-1">
                        Nomor WhatsApp / Kontak Anda <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="contact_info" 
                           name="contact_info" 
                           required
                           value="{{ old('contact_info', $item->contact_info) }}"
                           class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-700 focus:ring-emerald-700 shadow-2xs">
                    <p class="text-[10px] text-gray-400 mt-1">
                        🔒 Kontak Anda hanya dibagikan ke peminat yang pengajuannya Anda setujui.
                    </p>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('items.my') }}" 
                   class="px-5 py-3 rounded-2xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 rounded-2xl bg-emerald-800 hover:bg-emerald-900 text-white text-xs font-black shadow-2xs hover:shadow-xs transition-colors flex items-center space-x-1.5">
                    <x-icon name="check" class="w-4 h-4" />
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
