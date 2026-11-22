<x-app-layout>
    <div x-data="itemCreateForm()" class="w-full space-y-6">

        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2">
            <div>
                <span class="inline-flex items-center space-x-1.5 text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100/80 px-3 py-1 rounded-full mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-700"></span>
                    <span>Sirkular Kampus</span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Barang apa yang mau kamu bagikan?
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    Bantu adik tingkat atau rekan sekampus yang membutuhkan. Pasang foto dalam 1 menit dan tentukan apakah gratis, barter, atau harga pas.
                </p>
            </div>

            <div class="flex items-center space-x-2.5 bg-emerald-50 border border-emerald-200 px-4 py-2.5 rounded-2xl text-xs text-emerald-900 self-start md:self-auto shrink-0 shadow-2xs">
                <x-icon name="shield" class="w-5 h-5 text-emerald-700 shrink-0" />
                <div>
                    <span class="font-bold block">Instan & Terpercaya</span>
                    <span class="text-[11px] text-emerald-800">Listing langsung aktif dan siap diajukan mahasiswa lain.</span>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-xs text-red-700 shadow-2xs">
                <div class="font-bold mb-1 flex items-center space-x-1.5">
                    <x-icon name="alert-triangle" class="w-4 h-4 text-red-600 shrink-0" />
                    <span>Ada beberapa isian yang perlu kamu perbaiki:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Layout 2 Kolom Responsif: Form Input (Kiri) & Live Preview (Kanan) -->
        <div class="flex flex-col lg:flex-row gap-8 items-start w-full">
            
            <!-- ================= KOLOM KIRI: FORMULIR 4 LANGKAH ================= -->
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="w-full lg:flex-1 min-w-0 space-y-6">
                @csrf

                <!-- LANGKAH 1: INFORMASI DASAR BARANG -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-7 h-7 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">1</span>
                            <h2 class="font-bold text-base text-gray-900">Informasi Dasar Barang</h2>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">Wajib Diisi</span>
                    </div>

                    <!-- Judul Barang -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-gray-800 mb-1">
                            Judul Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" x-model="title" required
                               placeholder="Contoh: Kalkulator Ilmiah Casio fx-991EX ClassWiz Lengkap"
                               class="w-full text-xs sm:text-sm rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                        <p class="text-[11px] text-gray-400 mt-1">Gunakan judul yang jelas dan spesifik agar mudah dicari rekan sejurusan.</p>
                    </div>

                    <!-- Kategori Barang -->
                    <div>
                        <label for="category" class="block text-xs font-bold text-gray-800 mb-1">
                            Kategori Barang <span class="text-red-500">*</span>
                        </label>
                        <select id="category" name="category" x-model="category" required
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kondisi Barang (4 Radio Cards) -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-2">
                            Kondisi Barang <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($conditions as $cKey => $cDesc)
                                <div @click="condition = '{{ $cKey }}'"
                                     class="relative flex flex-col p-3.5 rounded-2xl border cursor-pointer transition-all text-xs select-none"
                                     :class="condition === '{{ $cKey }}' ? 'bg-emerald-50/80 border-emerald-600 shadow-2xs ring-2 ring-emerald-600' : 'bg-gray-50/50 border-gray-200 hover:bg-gray-50'">
                                    <input type="radio" name="condition" value="{{ $cKey }}" :checked="condition === '{{ $cKey }}'" class="sr-only">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-bold text-gray-900" :class="condition === '{{ $cKey }}' ? 'text-emerald-900' : ''">
                                            {{ $cKey }}
                                        </span>
                                        <span x-show="condition === '{{ $cKey }}'" x-cloak class="text-emerald-700 font-bold">
                                            <x-icon name="check" class="w-4 h-4 text-emerald-700 inline" />
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-gray-500 leading-tight">{{ $cDesc }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="description" class="block text-xs font-bold text-gray-800">
                                Deskripsi Lengkap <span class="text-red-500">*</span>
                            </label>
                            <span class="text-[11px] text-gray-400 font-mono" x-text="description.length + '/500'"></span>
                        </div>
                        <textarea id="description" name="description" x-model="description" rows="4" maxlength="500" required
                                  placeholder="Jelaskan riwayat pemakaian, kelengkapan (misal kardus/baterai), atau minus jika ada..."
                                  class="w-full text-xs sm:text-sm rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50 leading-relaxed"></textarea>
                    </div>
                </div>

                <!-- LANGKAH 2: FOTO BARANG (MAKSIMAL 3 FOTO) -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-7 h-7 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="font-bold text-base text-gray-900">Foto Barang</h2>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">Maksimal 3 Foto (JPG / PNG)</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Slot Foto 1 (Utama) -->
                        <div class="relative border-2 border-dashed border-gray-200 rounded-2xl p-2 text-center hover:border-emerald-500 transition-colors bg-gray-50/50 h-36 flex flex-col items-center justify-center overflow-hidden group">
                            <img x-show="photoPreview1" x-cloak :src="photoPreview1" class="absolute inset-0 w-full h-full object-cover">
                            <div x-show="!photoPreview1" class="space-y-1.5 flex flex-col items-center pointer-events-none">
                                <x-icon name="camera" class="w-6 h-6 text-gray-400" />
                                <p class="text-xs font-bold text-gray-700">Foto Utama</p>
                                <p class="text-[10px] text-gray-400">Klik untuk upload</p>
                            </div>
                            <input type="file" id="photoInput1" name="photos[]" accept="image/*" @change="handleImage($event, 1)" class="absolute inset-0 opacity-0 cursor-pointer" :class="photoPreview1 ? 'pointer-events-none' : ''">
                            <span x-show="photoPreview1" x-cloak class="absolute top-1.5 left-1.5 bg-emerald-800 text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-2xs z-10">
                                Utama
                            </span>
                            <button type="button" x-show="photoPreview1" x-cloak @click="removeImage(1)" class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs z-10 cursor-pointer">
                                &times;
                            </button>
                        </div>

                        <!-- Slot Foto 2 -->
                        <div class="relative border-2 border-dashed border-gray-200 rounded-2xl p-2 text-center hover:border-emerald-500 transition-colors bg-gray-50/50 h-36 flex flex-col items-center justify-center overflow-hidden group">
                            <img x-show="photoPreview2" x-cloak :src="photoPreview2" class="absolute inset-0 w-full h-full object-cover">
                            <div x-show="!photoPreview2" class="space-y-1.5 flex flex-col items-center pointer-events-none">
                                <x-icon name="image" class="w-6 h-6 text-gray-400" />
                                <p class="text-xs font-bold text-gray-700">Foto 2 (Detail)</p>
                                <p class="text-[10px] text-gray-400">Tampak Layar / Minus</p>
                            </div>
                            <input type="file" id="photoInput2" name="photos[]" accept="image/*" @change="handleImage($event, 2)" class="absolute inset-0 opacity-0 cursor-pointer" :class="photoPreview2 ? 'pointer-events-none' : ''">
                            <button type="button" x-show="photoPreview2" x-cloak @click="removeImage(2)" class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs z-10 cursor-pointer">
                                &times;
                            </button>
                        </div>

                        <!-- Slot Foto 3 -->
                        <div class="relative border-2 border-dashed border-gray-200 rounded-2xl p-2 text-center hover:border-emerald-500 transition-colors bg-gray-50/50 h-36 flex flex-col items-center justify-center overflow-hidden group">
                            <img x-show="photoPreview3" x-cloak :src="photoPreview3" class="absolute inset-0 w-full h-full object-cover">
                            <div x-show="!photoPreview3" class="space-y-1.5 flex flex-col items-center pointer-events-none">
                                <x-icon name="image" class="w-6 h-6 text-gray-400" />
                                <p class="text-xs font-bold text-gray-700">Foto 3 (Pelengkap)</p>
                                <p class="text-[10px] text-gray-400">Cover / Aksesoris</p>
                            </div>
                            <input type="file" id="photoInput3" name="photos[]" accept="image/*" @change="handleImage($event, 3)" class="absolute inset-0 opacity-0 cursor-pointer" :class="photoPreview3 ? 'pointer-events-none' : ''">
                            <button type="button" x-show="photoPreview3" x-cloak @click="removeImage(3)" class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs z-10 cursor-pointer">
                                &times;
                            </button>
                        </div>
                    </div>

                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start space-x-2.5 text-xs text-emerald-950">
                        <x-icon name="info" class="w-4 h-4 text-emerald-700 shrink-0 mt-0.5" />
                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                            <strong>Tips:</strong> Foto di tempat terang dan perlihatkan sudut fungsional barang agar pengajuan lebih cepat direspons rekan kampus.
                        </p>
                    </div>
                </div>

                <!-- LANGKAH 3: PILIH FORMAT LISTING (KONDISIONAL HARGA PAS / BARTER / GRATIS) -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-7 h-7 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">3</span>
                            <h2 class="font-bold text-base text-gray-900">Pilih Format Listing</h2>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">Transparan & Adil</span>
                    </div>

                    <!-- 3 Pilihan Mode (Cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Mode Gratis -->
                        <div @click="mode = 'gratis'" 
                             class="relative flex flex-col justify-between p-4 rounded-2xl border cursor-pointer transition-all select-none"
                             :class="mode === 'gratis' ? 'bg-emerald-50/80 border-emerald-600 ring-2 ring-emerald-600 shadow-2xs' : 'bg-gray-50/50 border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="mode" value="gratis" :checked="mode === 'gratis'" class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-bold text-emerald-800 flex items-center space-x-1">
                                        <x-icon name="gift" class="w-3.5 h-3.5 text-emerald-800" />
                                        <span>Gratis</span>
                                    </span>
                                    <span x-show="mode === 'gratis'" x-cloak class="text-emerald-700 font-bold text-xs">●</span>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Pahala & Bersih</h3>
                                <p class="text-[10px] text-gray-500 mt-1 leading-tight">Bebaskan barang tanpa biaya sepeserpun untuk yang paling butuh.</p>
                            </div>
                            <span class="mt-3 text-xs font-black text-emerald-800">Rp 0</span>
                        </div>

                        <!-- Mode Harga Pas -->
                        <div @click="mode = 'harga_pas'" 
                             class="relative flex flex-col justify-between p-4 rounded-2xl border cursor-pointer transition-all select-none"
                             :class="mode === 'harga_pas' ? 'bg-amber-50/80 border-amber-600 ring-2 ring-amber-600 shadow-2xs' : 'bg-gray-50/50 border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="mode" value="harga_pas" :checked="mode === 'harga_pas'" class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-bold text-amber-800 flex items-center space-x-1">
                                        <x-icon name="tag" class="w-3.5 h-3.5 text-amber-800" />
                                        <span>Harga Pas</span>
                                    </span>
                                    <span x-show="mode === 'harga_pas'" x-cloak class="text-amber-700 font-bold text-xs">●</span>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Jual Santai Mahasiswa</h3>
                                <p class="text-[10px] text-gray-500 mt-1 leading-tight">Tetapkan nominal terjangkau tanpa drama tawar-menawar berbelit.</p>
                            </div>
                            <span class="mt-3 text-xs font-black text-amber-800">Tetap & Pas!</span>
                        </div>

                        <!-- Mode Barter -->
                        <div @click="mode = 'barter'" 
                             class="relative flex flex-col justify-between p-4 rounded-2xl border cursor-pointer transition-all select-none"
                             :class="mode === 'barter' ? 'bg-teal-50/80 border-teal-600 ring-2 ring-teal-600 shadow-2xs' : 'bg-gray-50/50 border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="mode" value="barter" :checked="mode === 'barter'" class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-bold text-teal-800 flex items-center space-x-1">
                                        <x-icon name="repeat" class="w-3.5 h-3.5 text-teal-800" />
                                        <span>Barter</span>
                                    </span>
                                    <span x-show="mode === 'barter'" x-cloak class="text-teal-700 font-bold text-xs">●</span>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Tukar Guling</h3>
                                <p class="text-[10px] text-gray-500 mt-1 leading-tight">Tukar dengan perlengkapan atau modul matkul lain yang kamu perlukan.</p>
                            </div>
                            <span class="mt-3 text-xs font-black text-teal-800">Tukar Barang</span>
                        </div>
                    </div>

                    <!-- Field Dinamis 1: Nominal Harga Pas (HANYA AKTIF JIKA HARGA PAS DIPILIH) -->
                    <div x-show="mode === 'harga_pas'" x-cloak x-transition class="space-y-2 p-4 rounded-2xl bg-amber-50/70 border border-amber-200">
                        <label for="price" class="block text-xs font-bold text-amber-900">
                            Nominal Harga Pas (IDR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative max-w-sm">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-bold text-amber-800">Rp</span>
                            <input type="number" id="price" name="price" x-model="price" min="0" step="1000"
                                   placeholder="45000"
                                   :required="mode === 'harga_pas'"
                                   class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm font-bold text-gray-900 rounded-xl border-amber-300 focus:border-amber-600 focus:ring-amber-600 bg-white shadow-2xs">
                        </div>
                        <p class="text-[11px] text-amber-800 flex items-center space-x-1.5">
                            <x-icon name="lock" class="w-3.5 h-3.5 text-amber-700 shrink-0" />
                            <span>Harga ini bersifat pasti dan tidak dapat ditawar oleh peminat yang mengajukan.</span>
                        </p>
                    </div>

                    <!-- Field Dinamis 2: Deskripsi Barang Penukar (HANYA AKTIF JIKA BARTER DIPILIH) -->
                    <div x-show="mode === 'barter'" x-cloak x-transition class="space-y-2 p-4 rounded-2xl bg-teal-50/70 border border-teal-200">
                        <label for="barter_request" class="block text-xs font-bold text-teal-900">
                            Barang yang Kamu Cari untuk Ditukar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="barter_request" name="barter_request" x-model="barter_request"
                               placeholder="Contoh: Mouse Wireless Logitech M331 / Keyboard Mini"
                               :required="mode === 'barter'"
                               class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border-teal-300 focus:border-teal-600 focus:ring-teal-600 bg-white shadow-2xs">
                        <p class="text-[11px] text-teal-800">Sebutkan beberapa alternatif barang agar peluang ada yang barter lebih besar.</p>
                    </div>
                </div>

                <!-- LANGKAH 4: INFORMASI KONTAK & LOKASI COD -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-7 h-7 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">4</span>
                            <h2 class="font-bold text-base text-gray-900">Informasi Kontak & Janji Temu (COD)</h2>
                        </div>
                        <x-icon name="shield-check" class="w-5 h-5 text-emerald-700" />
                    </div>

                    <div>
                        <label for="contact_info" class="block text-xs font-bold text-gray-800 mb-1">
                            Instruksi Kontak Bebas & Lokasi Nyaman Kamu <span class="text-red-500">*</span>
                        </label>
                        <textarea id="contact_info" name="contact_info" rows="3" required
                                  placeholder="Contoh: Nomor WhatsApp 0812-3456-7890 (Andi) atau DM IG @andipratama. Biasa di kampus Senin-Kamis jam makan siang sekitar Kantin Fasilkom."
                                  class="w-full text-xs sm:text-sm rounded-xl border-gray-200 focus:border-emerald-700 focus:ring-emerald-700 py-3 px-3.5 bg-gray-50/50 leading-relaxed">{{ old('contact_info', auth()->user()->phone ? 'WhatsApp: ' . auth()->user()->phone . ' (' . auth()->user()->name . ')' : '') }}</textarea>
                    </div>

                    <!-- Notice Privasi -->
                    <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start space-x-3 text-xs text-emerald-950">
                        <x-icon name="shield-check" class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" />
                        <div>
                            <span class="font-bold block text-emerald-900">Privasi Aman Terlindungi</span>
                            <p class="text-[11px] text-emerald-800 mt-0.5 leading-relaxed">
                                Kontak dan instruksi ini <strong>HANYA akan ditampilkan kepada mahasiswa peminat yang kamu setujui pengajuannya</strong>. Nomor dan media sosial kamu tidak pernah terekspos di katalog publik.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Bawah -->
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('items.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm rounded-xl shadow-2xs transition-colors flex items-center space-x-2 cursor-pointer">
                        <span>Publikasikan Barang Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                    </button>
                </div>

            </form>

            <!-- ================= KOLOM KANAN: LIVE PREVIEW KARTU FEED ================= -->
            <div class="w-full lg:w-80 xl:w-96 shrink-0 min-w-0 sticky top-24 space-y-4">
                
                <div class="bg-white rounded-3xl p-5 border border-gray-200 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">
                            Preview Kartu Feed
                        </h3>
                        <span class="inline-flex items-center text-[10px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1.5 animate-pulse"></span>
                            Live
                        </span>
                    </div>

                    <!-- KARTU PREVIEW DINAMIS (ALPINE.JS) -->
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-2xs flex flex-col justify-between">
                        
                        <!-- Gambar & Badge -->
                        <div class="relative w-full h-44 bg-gray-100 overflow-hidden">
                            <img x-show="photoPreview1" x-cloak :src="photoPreview1" class="w-full h-full object-cover">
                            <div x-show="!photoPreview1" class="w-full h-full flex flex-col items-center justify-center bg-emerald-50/40 text-emerald-700/60 p-4 text-center">
                                <x-icon name="package" class="w-10 h-10 mb-1 text-emerald-700/50" />
                                <span class="text-[10px] font-bold uppercase tracking-wider">Foto Barang Kamu</span>
                            </div>

                            <!-- Overlay Gelap Tipis -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>

                            <!-- Badge Mode (Kiri Atas) -->
                            <div class="absolute top-2.5 left-2.5 z-10">
                                <span x-show="mode === 'harga_pas'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold bg-amber-500 text-white shadow-2xs">
                                    <x-icon name="tag" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Rp <span x-text="formatPrice(price)"></span></span>
                                </span>
                                <span x-show="mode === 'gratis'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold bg-emerald-700 text-white shadow-2xs">
                                    <x-icon name="gift" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Gratis</span>
                                </span>
                                <span x-show="mode === 'barter'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold bg-teal-700 text-white shadow-2xs">
                                    <x-icon name="repeat" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Barter</span>
                                </span>
                            </div>

                            <!-- Badge Ketersediaan (Kanan Atas) -->
                            <div class="absolute top-2.5 right-2.5 z-10">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-semibold bg-white/95 text-emerald-800 shadow-2xs border border-emerald-100">
                                    ● Tersedia
                                </span>
                            </div>

                            <!-- Pita Barter Request -->
                            <div x-show="mode === 'barter' && barter_request" x-cloak class="absolute bottom-2 left-2 right-2 bg-black/75 backdrop-blur-xs text-white text-[10px] py-1 px-2 rounded-md truncate z-10">
                                <span class="text-teal-300 font-bold">⇄ Tukar:</span> <span x-text="barter_request"></span>
                            </div>
                        </div>

                        <!-- Konten Kartu -->
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-[10px] text-gray-400 font-medium mb-1">
                                    <span class="text-emerald-800 font-semibold bg-emerald-50 px-1.5 py-0.5 rounded" x-text="category"></span>
                                    <span>Baru saja</span>
                                </div>

                                <h4 class="font-bold text-gray-900 text-xs line-clamp-1" x-text="title && title.trim() ? title : 'Judul barang akan muncul di sini...'">
                                    Judul barang akan muncul di sini...
                                </h4>

                                <p class="text-[11px] text-gray-500 line-clamp-2 mt-1.5 leading-relaxed" 
                                   x-text="description && description.trim() ? description : 'Deskripsi singkat barang akan tampil di sini saat kamu mengetik...'"></p>

                                <div class="mt-2 flex flex-wrap gap-1 text-[10px]">
                                    <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 flex items-center space-x-1">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-700" />
                                        <span x-text="condition"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Pemilik -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-2 truncate">
                                    <img class="w-6 h-6 rounded-full object-cover border border-emerald-700/20" 
                                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=144d37&color=ffffff' }}" 
                                         alt="{{ Auth::user()->name }}">
                                    <div class="truncate text-[11px] font-bold text-gray-800">
                                        {{ Auth::user()->name }}
                                    </div>
                                </div>
                                <span class="text-[10px] text-emerald-700 font-bold">Milik Kamu</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Kartu Edukasi Kampus -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-xs text-emerald-950 space-y-2">
                    <div class="flex items-center space-x-2 font-bold text-emerald-900">
                        <x-icon name="zap" class="w-4 h-4 text-emerald-700" />
                        <span>Sirkulasi Cepat</span>
                    </div>
                    <p class="text-[11px] text-emerald-800 leading-relaxed">
                        Rata-rata barang di waris.in mendapatkan pengajuan pertama dalam waktu <strong>kurang dari 14 jam</strong> setelah dipasang.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-4 text-xs text-gray-500 flex items-start space-x-2.5">
                    <x-icon name="leaf" class="w-4 h-4 text-emerald-700 shrink-0 mt-0.5" />
                    <p class="text-[11px] text-gray-600 leading-relaxed">
                        Setiap barang yang diwariskan mengurangi jejak karbon produksi barang baru di lingkungan kampus kita.
                    </p>
                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            if (window.Alpine) {
                Alpine.data('itemCreateForm', () => itemCreateFormState());
            }
        });

        function itemCreateFormState() {
            return {
                title: @json(old('title', '')),
                category: @json(old('category', 'Elektronik & Gadget Belajar')),
                condition: @json(old('condition', 'Bekas Layak Pakai')),
                description: @json(old('description', '')),
                mode: @json(old('mode', 'harga_pas')),
                price: @json((float) old('price', 45000)),
                barter_request: @json(old('barter_request', '')),
                photoPreview1: null,
                photoPreview2: null,
                photoPreview3: null,
                formatPrice(val) {
                    if (!val) return '0';
                    return new Intl.NumberFormat('id-ID').format(val);
                },
                handleImage(e, slot) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            if (slot === 1) this.photoPreview1 = event.target.result;
                            if (slot === 2) this.photoPreview2 = event.target.result;
                            if (slot === 3) this.photoPreview3 = event.target.result;
                        };
                        reader.readAsDataURL(files[0]);
                    }
                },
                removeImage(slot) {
                    if (slot === 1) this.photoPreview1 = null;
                    if (slot === 2) this.photoPreview2 = null;
                    if (slot === 3) this.photoPreview3 = null;
                    const input = document.getElementById('photoInput' + slot);
                    if (input) input.value = '';
                }
            };
        }

        window.itemCreateForm = itemCreateFormState;
    </script>
</x-app-layout>
