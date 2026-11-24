<x-app-layout>
    <script>
        window.handleImageGlobal = function(event, slot) {
            const input = event.target || event;
            const files = input.files;
            if (files && files.length > 0) {
                const file = files[0];
                const sizeKb = (file.size / 1024).toFixed(1);
                console.log('Upload image success: ' + file.name + ' (' + sizeKb + ' KB) pada slot ' + slot);
                console.log('[Foto Barang] Berhasil memilih file foto:', {
                    slot: slot,
                    nama: file.name,
                    tipe: file.type,
                    ukuran: sizeKb + ' KB'
                });

                const url = URL.createObjectURL(file);

                // 1. Tampilkan container preview & sembunyikan placeholder
                const container = document.getElementById('previewContainer' + slot);
                if (container) {
                    container.style.display = 'block';
                    container.removeAttribute('x-cloak');
                }
                const placeholder = document.getElementById('placeholder' + slot);
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                const img = document.getElementById('previewImg' + slot);
                if (img) {
                    img.src = url;
                }
                const nameLabel = document.getElementById('photoNameLabel' + slot);
                if (nameLabel) {
                    nameLabel.textContent = file.name + ' (' + sizeKb + ' KB)';
                }
                const slotBox = document.getElementById('photoSlotBox' + slot);
                if (slotBox) {
                    slotBox.classList.remove('border-dashed', 'border-slate-300', 'bg-slate-50/60');
                    slotBox.classList.add('border-emerald-500', 'bg-emerald-50/30', 'ring-2', 'ring-emerald-500/30');
                }

                // 2. Tampilkan Banner Notifikasi Sukses Unggah Foto
                const notice = document.getElementById('photoSuccessNotification');
                if (notice) {
                    notice.style.display = 'flex';
                    const noticeText = document.getElementById('photoSuccessText');
                    if (noticeText) {
                        noticeText.textContent = 'Foto "' + file.name + '" berhasil dipilih dan siap dipasang!';
                    }
                }

                // 3. Sinkronkan ke Live Preview Feed Card (Kanan) jika Slot 1
                if (slot === 1) {
                    const feedImg = document.getElementById('feedCardPreviewImg');
                    if (feedImg) {
                        feedImg.src = url;
                        feedImg.style.display = 'block';
                        feedImg.removeAttribute('x-cloak');
                    }
                    const feedPlaceholder = document.getElementById('feedCardPreviewPlaceholder');
                    if (feedPlaceholder) {
                        feedPlaceholder.style.display = 'none';
                    }
                }

                // 4. Sinkronkan ke Alpine.js component data jika aktif
                try {
                    const formEl = document.querySelector('[x-data]');
                    if (formEl && window.Alpine && Alpine.$data) {
                        const alpineData = Alpine.$data(formEl);
                        if (alpineData) {
                            if (slot === 1) {
                                alpineData.photoPreview1 = url;
                                alpineData.photoName1 = file.name;
                            } else if (slot === 2) {
                                alpineData.photoPreview2 = url;
                                alpineData.photoName2 = file.name;
                            } else if (slot === 3) {
                                alpineData.photoPreview3 = url;
                                alpineData.photoName3 = file.name;
                            }
                        }
                    }
                } catch (err) {
                    console.warn('Alpine sync notice:', err);
                }
            }
        };

        window.removeImageGlobal = function(slot) {
            console.log('[Foto Barang] Menghapus foto dari slot ' + slot);
            const input = document.getElementById('photoInput' + slot);
            if (input) input.value = '';

            const container = document.getElementById('previewContainer' + slot);
            if (container) container.style.display = 'none';

            const placeholder = document.getElementById('placeholder' + slot);
            if (placeholder) placeholder.style.display = 'flex';

            const img = document.getElementById('previewImg' + slot);
            if (img) img.src = '';

            const slotBox = document.getElementById('photoSlotBox' + slot);
            if (slotBox) {
                slotBox.classList.add('border-dashed', 'border-slate-300', 'bg-slate-50/60');
                slotBox.classList.remove('border-emerald-500', 'bg-emerald-50/30', 'ring-2', 'ring-emerald-500/30');
            }

            if (slot === 1) {
                const feedImg = document.getElementById('feedCardPreviewImg');
                if (feedImg) {
                    feedImg.src = '';
                    feedImg.style.display = 'none';
                }
                const feedPlaceholder = document.getElementById('feedCardPreviewPlaceholder');
                if (feedPlaceholder) {
                    feedPlaceholder.style.display = 'flex';
                }
            }

            const p1 = document.getElementById('previewContainer1');
            const p2 = document.getElementById('previewContainer2');
            const p3 = document.getElementById('previewContainer3');
            const hasAny = (p1 && p1.style.display !== 'none') || (p2 && p2.style.display !== 'none') || (p3 && p3.style.display !== 'none');
            if (!hasAny) {
                const notice = document.getElementById('photoSuccessNotification');
                if (notice) notice.style.display = 'none';
            }

            try {
                const formEl = document.querySelector('[x-data]');
                if (formEl && window.Alpine && Alpine.$data) {
                    const alpineData = Alpine.$data(formEl);
                    if (alpineData) {
                        if (slot === 1) {
                            alpineData.photoPreview1 = null;
                            alpineData.photoName1 = '';
                        } else if (slot === 2) {
                            alpineData.photoPreview2 = null;
                            alpineData.photoName2 = '';
                        } else if (slot === 3) {
                            alpineData.photoPreview3 = null;
                            alpineData.photoName3 = '';
                        }
                    }
                }
            } catch (err) {}
        };

        function itemCreateForm() {
            return {
                title: @js(old('title', '')),
                category: @js(old('category', $categories[0] ?? 'Elektronik & Gadget Belajar')),
                condition: @js(old('condition', 'Bekas Layak Pakai')),
                description: @js(old('description', '')),
                mode: @js(old('mode', 'harga_pas')),
                price: @js(old('price', 45000)),
                barter_request: @js(old('barter_request', '')),
                photoPreview1: null,
                photoPreview2: null,
                photoPreview3: null,
                photoName1: '',
                photoName2: '',
                photoName3: '',
                formatPrice(val) {
                    if (!val) return '0';
                    return new Intl.NumberFormat('id-ID').format(val);
                },
                handleImage(e, slot) {
                    window.handleImageGlobal(e, slot);
                },
                removeImage(slot) {
                    window.removeImageGlobal(slot);
                }
            };
        }
        window.itemCreateForm = itemCreateForm;
        if (window.Alpine) {
            Alpine.data('itemCreateForm', itemCreateForm);
        } else {
            document.addEventListener('alpine:init', () => {
                Alpine.data('itemCreateForm', itemCreateForm);
            });
        }
    </script>

    <div x-data="itemCreateForm()" class="w-full space-y-6">

        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2 border-b border-slate-200/80">
            <div>
                <nav class="flex items-center space-x-2 text-xs font-medium text-slate-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('items.index') }}" class="hover:text-emerald-800 transition-colors">Katalog</a>
                    <span>/</span>
                    <span class="text-slate-800 font-semibold">Pasang Barang</span>
                </nav>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
                    Pasang Barang Kuliah
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Oper perlengkapan kuliahmu ke rekan sekampus yang membutuhkan. Tentukan formatnya: gratis, harga pas, atau barter.
                </p>
            </div>

            <div class="flex items-center space-x-2 bg-emerald-50/80 border border-emerald-200/80 px-3.5 py-2 rounded-xl text-xs text-emerald-900 shrink-0">
                <x-icon name="check-circle" class="w-4 h-4 text-emerald-700 shrink-0" />
                <span class="font-medium">Listing langsung aktif setelah dipasang</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 text-xs text-rose-800 shadow-2xs">
                <div class="font-bold mb-1 flex items-center space-x-1.5">
                    <x-icon name="alert-triangle" class="w-4 h-4 text-rose-600 shrink-0" />
                    <span>Harap periksa isian berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Layout 2 Kolom: Form Input (Kiri) & Live Preview (Kanan) -->
        <div class="flex flex-col lg:flex-row gap-8 items-start w-full">
            
            <!-- ================= KOLOM KIRI: FORMULIR 4 LANGKAH ================= -->
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="w-full lg:flex-1 min-w-0 space-y-6">
                @csrf

                <!-- LANGKAH 1: INFORMASI DASAR BARANG -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-6 h-6 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">1</span>
                            <h2 class="font-bold text-sm sm:text-base text-gray-900">Informasi Dasar Barang</h2>
                        </div>
                        <span class="text-xs font-medium text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">Wajib Diisi</span>
                    </div>

                    <!-- Judul Barang -->
                    <div>
                        <label for="title" class="block text-xs font-semibold text-gray-800 mb-1">
                            Judul Barang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" x-model="title" required
                               placeholder="Contoh: Kalkulator Ilmiah Casio fx-991EX ClassWiz Lengkap"
                               class="w-full text-xs sm:text-sm rounded-xl border-slate-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-slate-50/50">
                        <p class="text-xs text-gray-400 mt-1">Gunakan judul yang spesifik agar mudah dicari rekan sejurusan.</p>
                    </div>

                    <!-- Kategori Barang -->
                    <div>
                        <label for="category" class="block text-xs font-semibold text-gray-800 mb-1">
                            Kategori Barang <span class="text-rose-500">*</span>
                        </label>
                        <select id="category" name="category" x-model="category" required
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-slate-50/50 font-medium">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kondisi Barang (Radio Selection dengan x-model langsung) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-2">
                            Kondisi Barang <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($conditions as $cKey => $cDesc)
                                @php
                                    $isDefault = old('condition', 'Bekas Layak Pakai') === $cKey;
                                    $condId = 'condition_' . Str::slug($cKey);
                                @endphp
                                <label for="{{ $condId }}"
                                       @click="condition = '{{ $cKey }}'"
                                       class="group relative flex items-start p-3.5 rounded-xl border cursor-pointer transition-all text-xs select-none space-x-3 bg-slate-50/50 border-slate-200 hover:bg-slate-50 has-[:checked]:bg-emerald-50/70 has-[:checked]:border-emerald-600 has-[:checked]:ring-1 has-[:checked]:ring-emerald-600 has-[:checked]:shadow-2xs"
                                       :class="condition === '{{ $cKey }}' ? 'bg-emerald-50/70 border-emerald-600 ring-1 ring-emerald-600 shadow-2xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                                    
                                    <!-- Radio Circle Fisik Terlihat Nyata -->
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0 mt-0.5 transition-colors group-has-[:checked]:border-emerald-700 group-has-[:checked]:bg-emerald-700"
                                         :class="condition === '{{ $cKey }}' ? 'border-emerald-700 bg-emerald-700' : 'border-slate-300 bg-white'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white transition-opacity group-has-[:checked]:opacity-100"
                                             :class="condition === '{{ $cKey }}' ? 'opacity-100' : 'opacity-0'"
                                             style="{{ $isDefault ? '' : 'display: none;' }}"
                                             x-show="condition === '{{ $cKey }}'"></div>
                                    </div>

                                    <input type="radio" 
                                           id="{{ $condId }}"
                                           name="condition" 
                                           value="{{ $cKey }}" 
                                           {{ $isDefault ? 'checked' : '' }}
                                           x-model="condition" 
                                           @change="condition = $el.value"
                                           class="sr-only">

                                    <div class="flex-1">
                                        <span class="font-bold text-gray-900 block group-has-[:checked]:text-emerald-950" 
                                              :class="condition === '{{ $cKey }}' ? 'text-emerald-950' : ''">
                                            {{ $cKey }}
                                        </span>
                                        <span class="text-xs text-gray-500 leading-tight block mt-0.5">{{ $cDesc }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="description" class="block text-xs font-semibold text-gray-800">
                                Deskripsi Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-xs text-gray-400 font-mono" x-text="(description || '').length + '/500'"></span>
                        </div>
                        <textarea id="description" name="description" x-model="description" rows="3" maxlength="500" required
                                  placeholder="Jelaskan riwayat pemakaian, kelengkapan (misal baterai/cover), atau kondisi minus jika ada..."
                                  class="w-full text-xs sm:text-sm rounded-xl border-slate-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-slate-50/50 leading-relaxed"></textarea>
                    </div>
                </div>

                <!-- LANGKAH 2: FOTO BARANG (PREVIEW NYATA & INDIKASI STATUS FILE) -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-6 h-6 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="font-bold text-sm sm:text-base text-gray-900">Foto Barang</h2>
                        </div>
                        <span class="text-xs text-gray-400">Maksimal 3 Foto (JPG / PNG)</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        
                        <!-- Slot Foto 1 (Utama) -->
                        <div id="photoSlotBox1"
                             class="relative border-2 rounded-xl p-2 text-center transition-all h-36 flex flex-col items-center justify-center overflow-hidden group cursor-pointer border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60"
                             :class="photoPreview1 ? 'border-emerald-500 bg-emerald-50/20' : 'border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60'">
                            
                            <!-- State Preview Saat File Sudah Dipilih -->
                            <div id="previewContainer1" 
                                 x-show="photoPreview1" 
                                 style="display: none;"
                                 class="absolute inset-0 w-full h-full z-20">
                                <img id="previewImg1" :src="photoPreview1" src="" class="w-full h-full object-cover">
                                <div class="absolute top-1.5 left-1.5 flex items-center space-x-1 z-10">
                                    <span class="bg-emerald-800 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow-2xs flex items-center space-x-1">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-300" />
                                        <span>Foto Utama</span>
                                    </span>
                                </div>
                                <div id="photoNameLabel1" 
                                     class="absolute bottom-1.5 left-1.5 right-1.5 bg-black/75 backdrop-blur-xs text-white text-[10px] py-0.5 px-2 rounded truncate z-10 font-medium"
                                     x-text="photoName1"></div>
                                <button type="button" 
                                        onclick="window.removeImageGlobal(1)"
                                        @click.prevent.stop="removeImage(1)" 
                                        class="absolute top-1.5 right-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs cursor-pointer z-30"
                                        title="Hapus Foto">
                                    &times;
                                </button>
                            </div>

                            <!-- State Belum Ada File -->
                            <div id="placeholder1" 
                                 x-show="!photoPreview1" 
                                 class="space-y-1.5 flex flex-col items-center pointer-events-none z-0">
                                <x-icon name="camera" class="w-6 h-6 text-slate-400" />
                                <p class="text-xs font-semibold text-gray-800">Foto Utama</p>
                                <span class="text-[11px] text-emerald-800 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md font-medium">Pilih Berkas</span>
                            </div>

                            <!-- Real Native Invisible File Input -->
                            <input type="file" 
                                   id="photoInput1" 
                                   name="photos[]" 
                                   accept="image/*" 
                                   onchange="window.handleImageGlobal(event, 1)"
                                   @change="handleImage($event, 1)" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   :class="photoPreview1 ? 'pointer-events-none' : ''">
                        </div>

                        <!-- Slot Foto 2 (Detail) -->
                        <div id="photoSlotBox2"
                             class="relative border-2 rounded-xl p-2 text-center transition-all h-36 flex flex-col items-center justify-center overflow-hidden group cursor-pointer border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60"
                             :class="photoPreview2 ? 'border-emerald-500 bg-emerald-50/20' : 'border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60'">
                            
                            <!-- State Preview Saat File Sudah Dipilih -->
                            <div id="previewContainer2" 
                                 x-show="photoPreview2" 
                                 style="display: none;"
                                 class="absolute inset-0 w-full h-full z-20">
                                <img id="previewImg2" :src="photoPreview2" src="" class="w-full h-full object-cover">
                                <div class="absolute top-1.5 left-1.5 flex items-center space-x-1 z-10">
                                    <span class="bg-emerald-800 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow-2xs flex items-center space-x-1">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-300" />
                                        <span>Foto Detail</span>
                                    </span>
                                </div>
                                <div id="photoNameLabel2" 
                                     class="absolute bottom-1.5 left-1.5 right-1.5 bg-black/75 backdrop-blur-xs text-white text-[10px] py-0.5 px-2 rounded truncate z-10 font-medium"
                                     x-text="photoName2"></div>
                                <button type="button" 
                                        onclick="window.removeImageGlobal(2)"
                                        @click.prevent.stop="removeImage(2)" 
                                        class="absolute top-1.5 right-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs cursor-pointer z-30"
                                        title="Hapus Foto">
                                    &times;
                                </button>
                            </div>

                            <!-- State Belum Ada File -->
                            <div id="placeholder2" 
                                 x-show="!photoPreview2" 
                                 class="space-y-1.5 flex flex-col items-center pointer-events-none z-0">
                                <x-icon name="image" class="w-6 h-6 text-slate-400" />
                                <p class="text-xs font-semibold text-gray-800">Foto 2 (Detail)</p>
                                <span class="text-[11px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md font-medium">Opsional</span>
                            </div>

                            <!-- Real Native Invisible File Input -->
                            <input type="file" 
                                   id="photoInput2" 
                                   name="photos[]" 
                                   accept="image/*" 
                                   onchange="window.handleImageGlobal(event, 2)"
                                   @change="handleImage($event, 2)" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   :class="photoPreview2 ? 'pointer-events-none' : ''">
                        </div>

                        <!-- Slot Foto 3 (Pelengkap) -->
                        <div id="photoSlotBox3"
                             class="relative border-2 rounded-xl p-2 text-center transition-all h-36 flex flex-col items-center justify-center overflow-hidden group cursor-pointer border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60"
                             :class="photoPreview3 ? 'border-emerald-500 bg-emerald-50/20' : 'border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/60'">
                            
                            <!-- State Preview Saat File Sudah Dipilih -->
                            <div id="previewContainer3" 
                                 x-show="photoPreview3" 
                                 style="display: none;"
                                 class="absolute inset-0 w-full h-full z-20">
                                <img id="previewImg3" :src="photoPreview3" src="" class="w-full h-full object-cover">
                                <div class="absolute top-1.5 left-1.5 flex items-center space-x-1 z-10">
                                    <span class="bg-emerald-800 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow-2xs flex items-center space-x-1">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-300" />
                                        <span>Foto Pelengkap</span>
                                    </span>
                                </div>
                                <div id="photoNameLabel3" 
                                     class="absolute bottom-1.5 left-1.5 right-1.5 bg-black/75 backdrop-blur-xs text-white text-[10px] py-0.5 px-2 rounded truncate z-10 font-medium"
                                     x-text="photoName3"></div>
                                <button type="button" 
                                        onclick="window.removeImageGlobal(3)"
                                        @click.prevent.stop="removeImage(3)" 
                                        class="absolute top-1.5 right-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow-2xs cursor-pointer z-30"
                                        title="Hapus Foto">
                                    &times;
                                </button>
                            </div>

                            <!-- State Belum Ada File -->
                            <div id="placeholder3" 
                                 x-show="!photoPreview3" 
                                 class="space-y-1.5 flex flex-col items-center pointer-events-none z-0">
                                <x-icon name="image" class="w-6 h-6 text-slate-400" />
                                <p class="text-xs font-semibold text-gray-800">Foto 3 (Pelengkap)</p>
                                <span class="text-[11px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md font-medium">Opsional</span>
                            </div>

                            <!-- Real Native Invisible File Input -->
                            <input type="file" 
                                   id="photoInput3" 
                                   name="photos[]" 
                                   accept="image/*" 
                                   onchange="window.handleImageGlobal(event, 3)"
                                   @change="handleImage($event, 3)" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   :class="photoPreview3 ? 'pointer-events-none' : ''">
                        </div>

                    </div>

                    <!-- Banner Konfirmasi Berhasil Unggah Foto -->
                    <div id="photoSuccessNotification" style="display: none;" class="p-3 bg-emerald-50 border border-emerald-200/90 rounded-xl flex items-center space-x-2 text-xs text-emerald-900 shadow-2xs transition-all">
                        <x-icon name="check-circle" class="w-4 h-4 text-emerald-700 shrink-0" />
                        <span id="photoSuccessText" class="font-medium">Foto berhasil dipilih dan siap dipasang!</span>
                    </div>

                    <p class="text-xs text-gray-500 flex items-center space-x-1.5">
                        <x-icon name="info" class="w-3.5 h-3.5 text-emerald-700 shrink-0" />
                        <span>Foto yang jelas membantu rekan kampus lebih cepat merespons barangmu.</span>
                    </p>
                </div>

                <!-- LANGKAH 3: FORMAT LISTING (KONDISIONAL HARGA PAS / BARTER / GRATIS) -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-6 h-6 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">3</span>
                            <h2 class="font-bold text-sm sm:text-base text-gray-900">Format Listing</h2>
                        </div>
                        <span class="text-xs text-gray-400">Pilih salah satu</span>
                    </div>

                    <!-- 3 Pilihan Mode (Radio Selection dengan x-model langsung) -->
                    @php
                        $isGratis = old('mode', 'harga_pas') === 'gratis';
                        $isHargaPas = old('mode', 'harga_pas') === 'harga_pas';
                        $isBarter = old('mode', 'harga_pas') === 'barter';
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        
                        <!-- Mode Gratis -->
                        <label for="mode_gratis"
                               @click="mode = 'gratis'"
                               class="group relative flex flex-col justify-between p-3.5 rounded-xl border cursor-pointer transition-all select-none space-y-3 bg-slate-50/50 border-slate-200 hover:bg-slate-50 has-[:checked]:bg-emerald-50/80 has-[:checked]:border-emerald-600 has-[:checked]:ring-1 has-[:checked]:ring-emerald-600 has-[:checked]:shadow-2xs"
                               :class="mode === 'gratis' ? 'bg-emerald-50/80 border-emerald-600 ring-1 ring-emerald-600 shadow-2xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                            <input type="radio" 
                                   id="mode_gratis"
                                   name="mode" 
                                   value="gratis" 
                                   {{ $isGratis ? 'checked' : '' }}
                                   x-model="mode" 
                                   @change="mode = $el.value"
                                   class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-emerald-800 flex items-center space-x-1">
                                        <x-icon name="gift" class="w-3.5 h-3.5 text-emerald-800" />
                                        <span>Gratis</span>
                                    </span>
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center group-has-[:checked]:border-emerald-700 group-has-[:checked]:bg-emerald-700"
                                         :class="mode === 'gratis' ? 'border-emerald-700 bg-emerald-700' : 'border-slate-300 bg-white'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white transition-opacity group-has-[:checked]:opacity-100" 
                                             :class="mode === 'gratis' ? 'opacity-100' : 'opacity-0'"
                                             style="{{ $isGratis ? '' : 'display: none;' }}"
                                             x-show="mode === 'gratis'"></div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Hibah Rekan Kampus</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-snug">Berikan gratis tanpa biaya sepeserpun untuk yang membutuhkan.</p>
                            </div>
                            <span class="text-xs font-bold text-emerald-800">Rp 0 (Cuma-cuma)</span>
                        </label>

                        <!-- Mode Harga Pas -->
                        <label for="mode_harga_pas"
                               @click="mode = 'harga_pas'"
                               class="group relative flex flex-col justify-between p-3.5 rounded-xl border cursor-pointer transition-all select-none space-y-3 bg-slate-50/50 border-slate-200 hover:bg-slate-50 has-[:checked]:bg-amber-50/80 has-[:checked]:border-amber-600 has-[:checked]:ring-1 has-[:checked]:ring-amber-600 has-[:checked]:shadow-2xs"
                               :class="mode === 'harga_pas' ? 'bg-amber-50/80 border-amber-600 ring-1 ring-amber-600 shadow-2xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                            <input type="radio" 
                                   id="mode_harga_pas"
                                   name="mode" 
                                   value="harga_pas" 
                                   {{ $isHargaPas ? 'checked' : '' }}
                                   x-model="mode" 
                                   @change="mode = $el.value"
                                   class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-amber-800 flex items-center space-x-1">
                                        <x-icon name="tag" class="w-3.5 h-3.5 text-amber-800" />
                                        <span>Harga Pas</span>
                                    </span>
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center group-has-[:checked]:border-amber-600 group-has-[:checked]:bg-amber-600"
                                         :class="mode === 'harga_pas' ? 'border-amber-600 bg-amber-600' : 'border-slate-300 bg-white'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white transition-opacity group-has-[:checked]:opacity-100" 
                                             :class="mode === 'harga_pas' ? 'opacity-100' : 'opacity-0'"
                                             style="{{ $isHargaPas ? '' : 'display: none;' }}"
                                             x-show="mode === 'harga_pas'"></div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Jual Ramah Kantong</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-snug">Harga tetap terjangkau tanpa perlu tawar-menawar berbelit.</p>
                            </div>
                            <span class="text-xs font-bold text-amber-800">Nominal Pasti</span>
                        </label>

                        <!-- Mode Barter -->
                        <label for="mode_barter"
                               @click="mode = 'barter'"
                               class="group relative flex flex-col justify-between p-3.5 rounded-xl border cursor-pointer transition-all select-none space-y-3 bg-slate-50/50 border-slate-200 hover:bg-slate-50 has-[:checked]:bg-teal-50/80 has-[:checked]:border-teal-600 has-[:checked]:ring-1 has-[:checked]:ring-teal-600 has-[:checked]:shadow-2xs"
                               :class="mode === 'barter' ? 'bg-teal-50/80 border-teal-600 ring-1 ring-teal-600 shadow-2xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                            <input type="radio" 
                                   id="mode_barter"
                                   name="mode" 
                                   value="barter" 
                                   {{ $isBarter ? 'checked' : '' }}
                                   x-model="mode" 
                                   @change="mode = $el.value"
                                   class="sr-only">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-teal-800 flex items-center space-x-1">
                                        <x-icon name="repeat" class="w-3.5 h-3.5 text-teal-800" />
                                        <span>Barter</span>
                                    </span>
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center group-has-[:checked]:border-teal-600 group-has-[:checked]:bg-teal-600"
                                         :class="mode === 'barter' ? 'border-teal-600 bg-teal-600' : 'border-slate-300 bg-white'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white transition-opacity group-has-[:checked]:opacity-100" 
                                             :class="mode === 'barter' ? 'opacity-100' : 'opacity-0'"
                                             style="{{ $isBarter ? '' : 'display: none;' }}"
                                             x-show="mode === 'barter'"></div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-xs text-gray-900">Tukar Barang Kuliah</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-snug">Tukarkan dengan modul atau alat praktikum lain yang kamu perlukan.</p>
                            </div>
                            <span class="text-xs font-bold text-teal-800">Tukar Sesuai Kebutuhan</span>
                        </label>

                    </div>

                    <!-- Nominal Harga Pas (Hanya jika mode = harga_pas) -->
                    <div x-show="mode === 'harga_pas'" 
                         style="{{ $isHargaPas ? '' : 'display: none;' }}"
                         x-transition 
                         class="space-y-2 p-4 rounded-xl bg-amber-50/80 border border-amber-200">
                        <label for="price" class="block text-xs font-semibold text-amber-950">
                            Nominal Harga Pas (Rupiah) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative max-w-xs">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-bold text-amber-800">Rp</span>
                            <input type="number" id="price" name="price" x-model="price" min="0" step="1000"
                                   placeholder="45000"
                                   :required="mode === 'harga_pas'"
                                   class="w-full pl-10 pr-3 py-2 text-xs sm:text-sm font-bold text-gray-900 rounded-lg border-amber-300 focus:border-amber-600 focus:ring-amber-600 bg-white">
                        </div>
                        <p class="text-xs text-amber-800">Peminat tidak dapat menawar harga ini.</p>
                    </div>

                    <!-- Barang Penukar Barter (Hanya jika mode = barter) -->
                    <div x-show="mode === 'barter'" 
                         style="{{ $isBarter ? '' : 'display: none;' }}"
                         x-transition 
                         class="space-y-2 p-4 rounded-xl bg-teal-50/80 border border-teal-200">
                        <label for="barter_request" class="block text-xs font-semibold text-teal-950">
                            Barang yang Kamu Cari untuk Ditukar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="barter_request" name="barter_request" x-model="barter_request"
                               placeholder="Contoh: Mouse Wireless Logitech / Keyboard Mini / Buku Kalkulus"
                               :required="mode === 'barter'"
                               class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border-teal-300 focus:border-teal-600 focus:ring-teal-600 bg-white">
                        <p class="text-xs text-teal-800">Tuliskan beberapa pilihan barang agar peluang barter lebih besar.</p>
                    </div>
                </div>

                <!-- LANGKAH 4: KONTAK & JANJI TEMU (COD) -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-6 h-6 rounded-full bg-emerald-800 text-white font-bold text-xs flex items-center justify-center">4</span>
                            <h2 class="font-bold text-sm sm:text-base text-gray-900">Kontak & Janji Temu (COD Kampus)</h2>
                        </div>
                        <x-icon name="shield-check" class="w-5 h-5 text-emerald-700" />
                    </div>

                    <div>
                        <label for="contact_info" class="block text-xs font-semibold text-gray-800 mb-1">
                            Nomor WhatsApp & Titik Kumpul Nyaman Kamu <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="contact_info" name="contact_info" rows="2" required
                                  placeholder="Contoh: WhatsApp 0812-3456-7890 (Andi). Bisa ketemuan di Gazebo Fasilkom jam istirahat kuliah."
                                  class="w-full text-xs sm:text-sm rounded-xl border-slate-200 focus:border-emerald-700 focus:ring-emerald-700 py-2.5 px-3 bg-slate-50/50 leading-relaxed">{{ old('contact_info', auth()->user()->phone ? 'WhatsApp: ' . auth()->user()->phone . ' (' . auth()->user()->name . ')' : '') }}</textarea>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-start space-x-2.5 text-xs text-slate-600">
                        <x-icon name="lock" class="w-4 h-4 text-emerald-700 shrink-0 mt-0.5" />
                        <p class="leading-relaxed">
                            Kontak ini <strong>hanya terbuka bagi peminat yang kamu setujui</strong>. Nomor dan media sosialmu tidak dipublikasikan ke katalog umum.
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi Bawah -->
                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('items.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:bg-slate-100 transition-colors">
                        Batalkan
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center space-x-2 cursor-pointer">
                        <span>Pasang Barang Sekarang</span>
                        <x-icon name="arrow-right" class="w-4 h-4 text-white" />
                    </button>
                </div>

            </form>

            <!-- ================= KOLOM KANAN: LIVE PREVIEW KARTU FEED ================= -->
            <div class="w-full lg:w-80 xl:w-96 shrink-0 min-w-0 sticky top-24 space-y-4">
                
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">
                            Preview Kartu Katalog
                        </h3>
                        <span class="inline-flex items-center text-xs font-medium text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1.5"></span>
                            Live
                        </span>
                    </div>

                    <!-- KARTU PREVIEW DINAMIS -->
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs flex flex-col justify-between">
                        
                        <!-- Gambar & Badge -->
                        <div class="relative w-full h-44 bg-slate-100 overflow-hidden">
                            <img id="feedCardPreviewImg" x-show="photoPreview1" x-cloak :src="photoPreview1" class="w-full h-full object-cover">
                            <div x-show="!photoPreview1" class="w-full h-full flex flex-col items-center justify-center bg-slate-50 text-slate-400 p-4 text-center">
                                <x-icon name="package" class="w-8 h-8 mb-1 text-slate-300" />
                                <span class="text-xs font-medium">Foto barang akan tampil di sini</span>
                            </div>

                            <!-- Badge Mode -->
                            <div class="absolute top-2.5 left-2.5 z-10">
                                <span x-show="mode === 'harga_pas'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-amber-600 text-white shadow-2xs">
                                    <x-icon name="tag" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Rp <span x-text="formatPrice(price)"></span></span>
                                </span>
                                <span x-show="mode === 'gratis'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-800 text-white shadow-2xs">
                                    <x-icon name="gift" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Gratis</span>
                                </span>
                                <span x-show="mode === 'barter'" x-cloak class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-teal-700 text-white shadow-2xs">
                                    <x-icon name="repeat" class="w-3 h-3 text-white me-1 inline" />
                                    <span>Barter</span>
                                </span>
                            </div>

                            <!-- Badge Ketersediaan -->
                            <div class="absolute top-2.5 right-2.5 z-10">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-white text-emerald-800 shadow-2xs border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1"></span>
                                    Tersedia
                                </span>
                            </div>

                            <!-- Pita Barter Request -->
                            <div x-show="mode === 'barter' && barter_request" x-cloak class="absolute bottom-2 left-2 right-2 bg-black/75 backdrop-blur-xs text-white text-xs py-1 px-2 rounded truncate z-10">
                                <span class="text-teal-300 font-semibold">Tukar:</span> <span x-text="barter_request"></span>
                            </div>
                        </div>

                        <!-- Konten Kartu -->
                        <div class="p-3.5 flex-grow flex flex-col justify-between space-y-2">
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                    <span class="text-emerald-800 font-medium bg-emerald-50 px-1.5 py-0.5 rounded" x-text="category"></span>
                                    <span>Baru saja</span>
                                </div>

                                <h4 class="font-bold text-gray-900 text-xs line-clamp-1" x-text="title && title.trim() ? title : 'Judul barang akan muncul di sini...'">
                                    Judul barang akan muncul di sini...
                                </h4>

                                <p class="text-xs text-gray-500 line-clamp-2 mt-1 leading-relaxed" 
                                   x-text="description && description.trim() ? description : 'Deskripsi singkat barang akan tampil saat kamu mengetik...'"></p>

                                <div class="mt-2 flex flex-wrap gap-1 text-xs">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 flex items-center space-x-1">
                                        <x-icon name="check" class="w-3 h-3 text-emerald-700" />
                                        <span x-text="condition"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Pemilik -->
                            <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-2 truncate">
                                    <img class="w-5 h-5 rounded-full object-cover border border-emerald-800/20" 
                                         src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=065f46&color=ffffff' }}" 
                                         alt="{{ Auth::user()->name }}">
                                    <div class="truncate font-semibold text-gray-800">
                                        {{ Auth::user()->name }}
                                    </div>
                                </div>
                                <span class="text-emerald-800 font-medium">Milik Kamu</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>