# 🛠️ waris.in — Technical Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `subagent-driven-development` or `executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun platform web "waris.in" (Platform Tukar & Hibah Barang Mahasiswa Kampus) berbasis Laravel 13, Tailwind CSS, Alpine.js, dan MySQL yang siap didemokan secara stabil, responsif, dan bebas error untuk tugas akhir Pemrograman Web II.

**Target Selesai:** 7 Hari (Demo Ready)  
**Spec Document:** [`docs/PRD.md`](./PRD.md)  
**Dokumentasi Indeks:** [`docs/README.md`](./README.md)  

---

## 👥 Tim Pengembang & Peran (Project Team)

| Nama Anggota | Mapping Peran Acuan | Posisi & Peran Utama | Tanggung Jawab Utama |
| :--- | :--- | :--- | :--- |
| **Fajar Maulana** | *Revan* | **Lead Project & Lead Backend Engineer** | Arsitektur skema database & relasi Eloquent, controller inti transaksi, logika persetujuan atomik (*atomic auto-lock transaction*), auth middleware & penanganan user suspended, serta controller admin moderasi. |
| **Arsha** | *Aufa* | **Full-Stack & Frontend UI Engineer** | Pembuatan seluruh Blade views interaktif, implementasi form bersyarat (*dynamic conditional pricing*), komponen galeri & upload foto, alur pengajuan klaim/barter, antarmuka dashboard mahasiswa, dan integrasi responsif Tailwind CSS. |
| **Gebrian** | *Egi* | **Project Manager & QA Engineer** | Pengelolaan backlog sprint, penyusunan skenario pengujian UAT fungsional, kurasi dataset realistis seeder checkpoint demo, verifikasi kualitas kode, serta dokumentasi panduan presentasi. |

---

## ⏱️ Ringkasan Jadwal Sprint (Timeline 7 Hari)

```
[Hari 1 - Hari 2] SPRINT 1: Foundation, Custom Auth & Katalog Jelajahi Barang (SELESAI / IN PROGRESS)
        │
        ▼
[Hari 3 - Hari 5] SPRINT 2: Core Transaction Engine (Listing Baru, Detail, Klaim/Barter, & Auto-Lock)
        │
        ▼
[Hari 6 - Hari 7] SPRINT 3: Admin Moderasi, Seeder Demo Checkpoint, Hardening & UAT Sign-Off
```

---

## 🎨 Global Constraints & Design System

1. **Framework & Runtime:** PHP ^8.3, Laravel ^13.17, Tailwind CSS ^3.4, Alpine.js v3.x, MySQL 8.x.
2. **Palet Warna & Identitas Visual (Waris.in Brand):**
   * **Warna Utama (Emerald Forest):** `emerald-800` (`#065f46`), `emerald-700` (`#047857`), `emerald-50` (soft background).
   * **Mode Gratis (Pahala/Hibah):** Badge & aksen `emerald-100` / `emerald-800` dengan ikon 🎁.
   * **Mode Harga Pas (Murah Mahasiswa):** Badge & aksen `amber-100` / `amber-800` dengan ikon 🏷️.
   * **Mode Barter (Tukar Barang):** Badge & aksen `teal-100` / `teal-800` dengan ikon 🔄.
3. **Komponen & UI:** Blade components (`components/item-card.blade.php`, `modal.blade.php`), Alpine.js untuk interaktivitas dinamis (toggle modal, conditional form input), kartu bergaya modern dengan `rounded-2xl` & `rounded-3xl` serta border halus `border-gray-100` atau `border-emerald-900/10`.
4. **Data Isolation & Security:**
   * Setiap aksi ubah/hapus barang wajib diamankan dengan `ItemPolicy` (hanya pemilik atau admin yang diizinkan).
   * Mahasiswa tidak dapat mengklaim barang milik dirinya sendiri.
   * Akun berstatus `suspended` otomatis diblokir saat mencoba login atau melakukan aksi di sistem.

---

## 🔍 Review Focus & Titik Rawan Kritis

1. **Race Condition pada Approval (Kritis):** Jika pemilik barang menerima beberapa klaim sekaligus, proses persetujuan (*approval*) wajib dibungkus dalam `DB::transaction()` dengan pessimistic locking `Item::lockForUpdate()` agar tidak ada 2 klaim yang sama-sama berstatus `approved`.
2. **Atomic Auto-Lock & Mass Rejection:** Seketika satu pengajuan disetujui, kolom `items.status` berubah menjadi `locked`, dan semua pengajuan lain untuk barang tersebut dengan status `pending` otomatis diubah menjadi `rejected`.
3. **Kerahasiaan Info Kontak:** Informasi kontak peminat (`contact_info`) tidak boleh terbuka ke publik atau peminat lain; kontak HANYA terbuka kepada pemilik barang setelah pengajuan berstatus `approved`.
4. **Conditional Input Sanitization:** Pada controller `ItemController@store`, jika mode barang adalah `gratis` atau `barter`, pastikan nilai `price` dipaksa bernilai `null` di sisi backend terlepas dari apapun yang dikirim dari form HTTP.
5. **Multi-Image Handling:** Validasi berkas foto (mimes: jpeg, png, jpg, webp; max 2MB) dan penyimpanan rapi ke direktori `storage/app/public/items`.

---

## 📂 Standar Struktur Direktori Proyek

```text
waris.in/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php        # Moderasi admin (Hapus item & suspend user)
│   │   │   ├── Auth/                      # Breeze Auth terspesialisasi (Register, Login)
│   │   │   ├── ClaimController.php        # Ajukan klaim, list pengajuan, approve/reject
│   │   │   ├── HomeController.php         # Beranda & hero statistik
│   │   │   ├── ItemController.php         # Katalog, detail, pasang barang, barang saya
│   │   │   └── ProfileController.php      # Edit profil mahasiswa
│   │   ├── Middleware/
│   │   │   ├── EnsureAdmin.php            # Proteksi akses halaman admin
│   │   │   └── EnsureNotSuspended.php     # Blokir akun mahasiswa yang di-suspend
│   │   └── Requests/                      # ItemStoreRequest, ClaimStoreRequest
│   ├── Models/                            # User, Item, ItemImage, Claim
│   └── Policies/                          # ItemPolicy, ClaimPolicy
├── database/
│   ├── migrations/                        # Tabel users, items, item_images, claims
│   └── seeders/DatabaseSeeder.php         # Data realistis untuk demo dosen
├── docs/                                  # PRD.md, IMPLEMENTATION_PLAN.md, SPRINT.md
├── resources/
│   ├── views/
│   │   ├── admin/                         # dashboard.blade.php, items.blade.php, users.blade.php
│   │   ├── claims/                        # incoming.blade.php, my-claims.blade.php
│   │   ├── components/                    # item-card.blade.php, modal.blade.php
│   │   ├── items/                         # index.blade.php, show.blade.php, create.blade.php, my-items.blade.php
│   │   └── layouts/                       # app.blade.php, navigation.blade.php, footer.blade.php
└── routes/web.php                         # Rute terstruktur per modul
```

---

# 🚀 SPRINT 1: Foundation, Custom Auth & Katalog (Status: In Progress)

### Task 1: Scaffolding, Layout Dasar & Navigasi Kampus
* **Sprint:** Sprint 1 (Hari 1)
* **PIC / Assignee:** Fajar Maulana (fajar)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[x] Selesai`

**Files:**
* Modify: `resources/views/layouts/app.blade.php`
* Modify: `resources/views/layouts/navigation.blade.php`
* Create: `resources/views/layouts/footer.blade.php`
* Modify: `tailwind.config.js`

- [x] **Step 1: Setup palet warna Emerald, Amber, Teal** di konfigurasi Tailwind.
- [x] **Step 2: Kustomisasi Navigation Bar** dengan logo waris.in, menu Beranda, Jelajahi, Pasang Barang, dan profil dropdown.
- [x] **Step 3: Buat Footer responsif** dengan pesan sirkularitas kampus dan tautan navigasi cepat.

---

### Task 2: Modul Autentikasi Mahasiswa & Registrasi Khusus Kampus
* **Sprint:** Sprint 1 (Hari 1–2)
* **PIC / Assignee:** Fajar Maulana (fajar)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[x] Selesai`

**Files:**
* Modify: `database/migrations/0001_01_01_000000_create_users_table.php`
* Modify: `app/Http/Controllers/Auth/RegisteredUserController.php`
* Modify: `resources/views/auth/register.blade.php`
* Modify: `resources/views/auth/login.blade.php`

- [x] **Step 1: Tambahkan field khusus mahasiswa** (`nim`, `faculty`, `batch`, `phone`, `avatar`, `role`, `status`) pada migrasi `users`.
- [x] **Step 2: Desain halaman registrasi khusus** yang memuat input NIM, pilihan Fakultas, nomor kontak WhatsApp, dan kata sandi.
- [x] **Step 3: Kustomisasi halaman login** dengan tema hijau emerald waris.in dan pesan sapaan hangat.

---

### Task 3: Modul Beranda & Katalog Jelajahi Barang
* **Sprint:** Sprint 1 (Hari 2)
* **PIC / Assignee:** Fajar Maulana & Arsha
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[x] Selesai (90% - Verifikasi akhir)`

**Files:**
* Modify: `app/Http/Controllers/HomeController.php`
* Modify: `app/Http/Controllers/ItemController.php`
* Modify: `resources/views/dashboard.blade.php`
* Modify: `resources/views/items/index.blade.php`
* Modify: `resources/views/components/item-card.blade.php`

- [x] **Step 1: Buat query pencarian & filter multi-parameter** (search text, mode transaksi, kategori, kondisi barang, fakultas pemilik, dan sorting harga/terbaru).
- [x] **Step 2: Rancang Hero Section & Card Mode Transaksi (01, 02, 03)** pada Beranda.
- [x] **Step 3: Susun kartu barang (`item-card`) modular** lengkap dengan badge mode (Gratis, Harga Pas, Barter), foto barang, info pemilik, dan status lock.

---

# ⚡ SPRINT 2: Core Transaction Engine (Listing, Detail & Klaim/Barter)

### Task 4: Halaman Detail Barang & Galeri Foto (`items.show`)
* **Sprint:** Sprint 2 (Hari 3)
* **PIC / Assignee:** Arsha (arsha)
* **Reviewer / QA:** Fajar Maulana (fajar)
* **Status:** `[ ] Belum Mulai (Target Hari 3)`

**Files:**
* Modify: `app/Http/Controllers/ItemController.php` (tambahkan method `show`)
* Create: `resources/views/items/show.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Implementasi method `ItemController@show`**
  Mengambil item beserta relasi `user`, `images`, dan mengecek apakah user yang sedang login sudah mengajukan klaim untuk item ini.
- [ ] **Step 2: Rancang layout detail barang responsif**
  Menampilkan galeri foto dengan thumbnail carousel, badge mode, judul, kondisi fisik & catatan kondisi, lokasi rencana serah terima di kampus, serta deskripsi lengkap.
- [ ] **Step 3: Logika tombol aksi kontekstual**
  * Jika barang milik sendiri: tampilkan tombol "Kelola Pengajuan Masuk" atau "Edit Barang".
  * Jika barang milik orang lain & status `available`: tampilkan tombol "Ajukan Klaim / Barter".
  * Jika status `locked`: tampilkan banner "Barang Sudah Di-Lock / Diambil".
- [ ] **Step 4: Verifikasi UAT**
  Uji buka detail barang untuk mode Gratis, Harga Pas, dan Barter; pastikan foto ter-render mulus.

---

### Task 5: Formulir Pasang Barang Dinamis & Upload Foto (`items.create` & `items.store`)
* **Sprint:** Sprint 2 (Hari 3–4)
* **PIC / Assignee:** Arsha (arsha)
* **Reviewer / QA:** Fajar Maulana (fajar)
* **Status:** `[ ] Belum Mulai (Target Hari 3–4)`

**Files:**
* Modify: `app/Http/Controllers/ItemController.php` (method `create`, `store`)
* Create: `app/Http/Requests/ItemStoreRequest.php`
* Create: `resources/views/items/create.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Buat Form Request `ItemStoreRequest`**
  Validasi aturan: `title` (required, max 255), `category` (required), `condition` (required), `mode` (required|in:gratis,harga_pas,barter), `price` (required_if:mode,harga_pas|nullable|integer|min:0), `barter_request` (required_if:mode,barter|nullable|string), `contact_info` (required), `photos.*` (image|mimes:jpeg,png,jpg,webp|max:2048).
- [ ] **Step 2: Buat tampilan `items/create.blade.php` dengan Alpine.js**
  * Dropdown/Pills pemilihan mode transaksi (Gratis / Harga Pas / Barter).
  * Field nominal harga otomatis aktif dan bersinar hanya ketika opsi "Harga Pas" dipilih, dan otomatis disembunyikan/dikosongkan saat mode Gratis/Barter (FR-04).
  * Field deskripsi barang yang diinginkan muncul saat mode "Barter" dipilih.
  * Preview foto interaktif sebelum formulir di-submit.
- [ ] **Step 3: Implementasi proses penyimpanan pada `ItemController@store`**
  Simpan item ke database, lakukan iterasi penyimpanan foto ke `storage/app/public/items`, buat record `item_images`, dan jadikan foto pertama sebagai `is_primary = true`.
- [ ] **Step 4: Verifikasi UAT**
  Simpan 3 barang uji (1 gratis, 1 harga pas, 1 barter) dan verifikasi bahwa `price` benar-benar bernilai `null` pada barang gratis/barter.

---

### Task 6: Manajemen Barang Saya & Pengaturan Listing Sendiri
* **Sprint:** Sprint 2 (Hari 4)
* **PIC / Assignee:** Arsha (arsha)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[ ] Belum Mulai (Target Hari 4)`

**Files:**
* Modify: `app/Http/Controllers/ItemController.php` (method `myItems`, `edit`, `update`, `destroy`)
* Create: `app/Policies/ItemPolicy.php`
* Create: `resources/views/items/my-items.blade.php`
* Create: `resources/views/items/edit.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Buat `ItemPolicy`** untuk otorisasi akses edit, update, dan delete hanya oleh pemilik sah barang.
- [ ] **Step 2: Rancang halaman `items/my-items.blade.php`**
  Menampilkan tabel/kartu daftar barang yang dipasang oleh mahasiswa yang sedang login, terbagi atas tab "Tersedia" dan "Terkunci/Selesai", dilengkapi jumlah pengajuan masuk untuk tiap barang.
- [ ] **Step 3: Implementasi fungsionalitas edit & delete item**
  Memungkinkan perubahan deskripsi, catatan kondisi, atau penghapusan listing jika belum di-lock.
- [ ] **Step 4: Verifikasi UAT**
  Coba hapus atau edit item milik user lain dan pastikan sistem menghasilkan response 403 Forbidden.

---

### Task 7: Alur Pengajuan Klaim & Tawaran Barter (`claims.store`)
* **Sprint:** Sprint 2 (Hari 4–5)
* **PIC / Assignee:** Arsha (UI Modal) & Fajar Maulana (Backend Service)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[ ] Belum Mulai (Target Hari 4–5)`

**Files:**
* Create: `app/Http/Controllers/ClaimController.php`
* Create: `app/Http/Requests/ClaimStoreRequest.php`
* Modify: `resources/views/items/show.blade.php` (Modal pengajuan klaim/barter)
* Modify: `routes/web.php`

- [ ] **Step 1: Buat Form Request `ClaimStoreRequest`**
  Validasi: `contact_info` (required), `message` (nullable|string), `offered_item_desc` (required jika mode barang adalah barter).
- [ ] **Step 2: Rancang modal interaktif di `items/show.blade.php`**
  * Untuk mode Gratis / Harga Pas: form input kontak WhatsApp & pesan santai mengapa membutuhkan barang tersebut.
  * Untuk mode Barter: textarea wajib untuk mendeskripsikan barang apa yang diajukan sebagai penukar.
- [ ] **Step 3: Backend logic pencegahan klaim ganda & klaim barang sendiri**
  * Gagalkan jika `item->user_id === auth()->id()`.
  * Gagalkan jika user sudah pernah mengajukan klaim berstatus `pending` untuk barang tersebut.
  * Gagalkan jika status barang sudah `locked`.
- [ ] **Step 4: Verifikasi UAT**
  Klaim barang dari user lain dan pastikan data tersimpan di tabel `claims` dengan status `pending`.

---

### Task 8: Dashboard Pengajuan Masuk & Approval Locking Atomic
* **Sprint:** Sprint 2 (Hari 5)
* **PIC / Assignee:** Fajar Maulana (Backend Lock Engine) & Arsha (UI Antarmuka)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[ ] Belum Mulai (Target Hari 5)`

**Files:**
* Modify: `app/Http/Controllers/ClaimController.php` (method `incomingClaims`, `approve`, `reject`)
* Create: `resources/views/claims/incoming.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Halaman `claims/incoming.blade.php`**
  Daftar seluruh barang milik user yang memiliki pengajuan masuk, mengelompokkan calon penerima, alasan pengajuan, deskripsi barter (jika ada), dan status.
- [ ] **Step 2: Engine Atomic Approval (`ClaimController@approve`)**
  Menggunakan `DB::transaction()`:
  ```php
  DB::transaction(function () use ($claim) {
      $item = Item::where('id', $claim->item_id)->lockForUpdate()->firstOrFail();
      if ($item->status === 'locked') {
          throw new \Exception('Barang sudah terkunci oleh pengajuan lain.');
      }
      $claim->update(['status' => 'approved']);
      $item->update(['status' => 'locked']);
      Claim::where('item_id', $item->id)
          ->where('id', '!=', $claim->id)
          ->where('status', 'pending')
          ->update(['status' => 'rejected']);
  });
  ```
- [ ] **Step 3: Tampilkan kontak peminat terpilih**
  Saat pengajuan di-approve, nomor kontak peminat terbuka jelas dengan tombol direct WhatsApp `https://wa.me/...`.
- [ ] **Step 4: Verifikasi UAT**
  Uji simultan approval: pastikan pengajuan pertama mengunci barang dan sisa pengajuan lainnya langsung berstatus `rejected`.

---

### Task 9: Dashboard Pengajuan Saya & Status Transaksi
* **Sprint:** Sprint 2 (Hari 5)
* **PIC / Assignee:** Arsha (arsha)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[ ] Belum Mulai (Target Hari 5)`

**Files:**
* Modify: `app/Http/Controllers/ClaimController.php` (method `myClaims`)
* Create: `resources/views/claims/my-claims.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Tampilkan daftar riwayat pengajuan klaim/barter** yang pernah diajukan oleh user yang sedang login.
- [ ] **Step 2: Badge status interaktif:**
  * 🟡 `Menunggu Persetujuan (Pending)`
  * 🟢 `Disetujui! Hubungi Pemilik (Approved)` $\rightarrow$ muncul tombol WhatsApp pemilik barang beserta lokasi pertemuan di kampus.
  * 🔴 `Belum Beruntung (Rejected / Locked by another user)`
- [ ] **Step 3: Verifikasi UAT**
  Pastikan mahasiswa peminat langsung melihat update status secara realtime saat pemilik menyetujui pengajuannya.

---

# 🛡️ SPRINT 3: Admin Moderasi, Seeder Demo & UAT Sign-Off

### Task 10: Modul Admin Moderasi (Hapus Listing & Suspend Akun)
* **Sprint:** Sprint 3 (Hari 6)
* **PIC / Assignee:** Fajar Maulana (fajar)
* **Reviewer / QA:** Gebrian (gebrian)
* **Status:** `[ ] Belum Mulai (Target Hari 6)`

**Files:**
* Create: `app/Http/Controllers/AdminController.php`
* Create: `app/Http/Middleware/EnsureAdmin.php`
* Create: `app/Http/Middleware/EnsureNotSuspended.php`
* Create: `resources/views/admin/dashboard.blade.php`
* Modify: `routes/web.php`

- [ ] **Step 1: Buat Middleware `EnsureAdmin`** (cek `auth()->user()->role === 'admin'`).
- [ ] **Step 2: Buat Middleware `EnsureNotSuspended`** (logout dan tolak user jika `status === 'suspended'`).
- [ ] **Step 3: Rancang halaman Admin Moderasi**
  * Tab Kelola Listing: Cari barang dan tombol aksi "Hapus Listing" (*force delete* jika melanggar ketentuan).
  * Tab Kelola Akun Mahasiswa: Daftar pengguna dengan tombol "Suspend Akun" dan modal input alasan suspend (FR-10, FR-11).
- [ ] **Step 4: Verifikasi UAT**
  Login sebagai admin, suspend akun uji, lalu coba login dengan akun tersebut untuk memastikan akses diblokir.

---

### Task 11: Seeder Checkpoint Realistis untuk Presentasi Demo
* **Sprint:** Sprint 3 (Hari 6)
* **PIC / Assignee:** Gebrian (gebrian) & Fajar Maulana (fajar)
* **Reviewer / QA:** Arsha (arsha)
* **Status:** `[ ] Belum Mulai (Target Hari 6)`

**Files:**
* Modify: `database/seeders/DatabaseSeeder.php`

- [ ] **Step 1: Seeding 5 Akun Mahasiswa Aktif + 1 Akun Admin Kampus** dengan data realistis (NIM, Fakultas Fasilkom, Farmasi, Teknik Mesin, Hukum, MIPA).
- [ ] **Step 2: Seeding minimal 12 Barang Kuliah Populer** (Buku Kalkulus, Jas Lab Kimia, Kalkulator Casio fx-991EX, Kemeja Sidang Putih, T-Square Gambar Arsitektur, dll.) yang mencakup ketiga mode (Gratis, Harga Pas, Barter).
- [ ] **Step 3: Seeding contoh klaim berstatus `pending`, `approved`, dan `rejected`** agar dosen penguji langsung melihat visual alur yang berjalan sempurna tanpa perlu mengisi data dari nol saat demo.
- [ ] **Step 4: Verifikasi UAT**
  Jalankan `php artisan migrate:fresh --seed` dan periksa kelengkapan katalog.

---

### Task 12: Pengujian UAT End-to-End & Demo Readiness Sign-Off
* **Sprint:** Sprint 3 (Hari 7)
* **PIC / Assignee:** Gebrian (gebrian), didukung Fajar & Arsha
* **Reviewer / QA:** Seluruh Tim
* **Status:** `[ ] Belum Mulai (Target Hari 7)`

**Files:**
* Create: `tests/Feature/ItemTransactionTest.php`
* Create: `docs/DEMO_GUIDE.md` (Opsional untuk panduan presentasi dosen)

- [ ] **Step 1: Buat automated feature test** untuk menguji alur registrasi, pasang barang, pengajuan klaim, approval, dan auto-lock.
- [ ] **Step 2: Uji lintas peramban & layar (Cross-browser & Mobile Responsive Test)** pada Chrome Desktop dan Chrome Mobile simulator.
- [ ] **Step 3: Final Security & Permission Audit:** Pastikan tidak ada data yang bocor atau dapat dimanipulasi tanpa izin.
- [ ] **Step 4: Tanda tangan persetujuan rilis demo (Sign-Off):** Semua acceptance criteria dari PRD terpenuhi 100%.
