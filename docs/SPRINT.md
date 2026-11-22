# 📅 SPRINT ROADMAP & WORK BREAKDOWN
## waris.in — Platform Tukar & Hibah Barang Kampus
*Target Rilis: 7 Hari (Demo Ready untuk Tugas Akhir Pemrograman Web II)*

---

## 👥 Tim & Tanggung Jawab (RACI)

| Nama Anggota | Mapping Peran Acuan | Posisi & Peran Utama | Fokus Utama di waris.in | Skills Rekomendasi Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Fajar Maulana** | *Revan* | **Lead Project & Lead Backend Engineer** | Skema Database, Relasi Eloquent, Logika Approval & Auto-Lock Atomik (`DB::transaction`), Auth Middleware, dan Modul Admin Moderasi | `security-and-hardening`, `test-driven-development`, `api-and-interface-design` |
| **Arsha** | *Aufa* | **Full-Stack & Frontend UI Engineer** | Blade Templates, Komponen Interaktif Alpine.js, Form Bersyarat (*Conditional Pricing*), Galeri Foto Barang, Tampilan Katalog & Detail, Antarmuka Dashboard Mahasiswa | `frontend-ui-engineering`, `impeccable`, `antislop-ui`, `antislop-layoutmobile` |
| **Gebrian** | *Egi* | **Project Manager & QA Engineer** | Sprint Tracking, Backlog Priority, Penyusunan Test Case, UAT Sign-Off, Seeder Data Realistis, dan Panduan Skenario Presentasi Demo ke Dosen | `verification-before-completion`, `code-review-and-quality` |

*(Catatan: Kolom **PIC** dan status checklist `[ ]` dapat diperbarui langsung oleh tim setiap kali ada progres harian).*

---

## 🛠️ Pemetaan Skills Populer & Efektif per Kategori Task

Berikut adalah *skills* terpasang yang dapat dioptimalkan selama pengembangan:

1. **Crafting UI & Interaksi Mahasiswa (Arsha):**
   * `frontend-ui-engineering`: Membangun komponen Blade yang modular, semantik, aksesibel, dan bersih dari redudansi markup.
   * `impeccable`: Menjaga konsistensi estetika modern bernuansa hijau kampus (`emerald-800`), tipografi yang tegas, serta micro-interactions yang halus pada tombol dan kartu.
   * `antislop-ui` & `antislop-layoutmobile`: Mencegah tampilan generik klise, memastikan kenyamanan tap pada perangkat smartphone, dan menjaga layout tetap responsif tanpa horizontal overflow.
2. **Keamanan Transaksi & Integritas Data (Fajar Maulana):**
   * `security-and-hardening`: Memastikan kebijakan otorisasi (*policies*) ketat pada edit/hapus barang, validasi kepemilikan data, dan proteksi akun mahasiswa berstatus suspended.
   * `test-driven-development`: Dipakai untuk menguji skenario race condition pada alur persetujuan (*approval*) klaim ganda sehingga tidak ada barang yang ter-lock dua kali.
   * `api-and-interface-design`: Menjamin validasi Form Request Laravel bersih, aman dari injection, dan mengembalikan pesan error yang ramah pengguna.
3. **Quality Gate & Verifikasi Demo (Gebrian):**
   * `verification-before-completion`: Menjamin setiap task hanya boleh dicentang selesai setelah ada bukti konkret (katalog berfungsi lancar, migration & seeder fresh tanpa error, alur end-to-end terverifikasi).
   * `code-review-and-quality`: Melakukan audit kualitas kode sebelum digabungkan (*merge*) ke branch utama `main`.

---

## 🧭 Ringkasan Jadwal Sprint (Timeline 7 Hari)

```
[Hari 1 - Hari 2] SPRINT 1: Foundation, Custom Auth & Katalog Jelajahi Barang (Fajar & Arsha)
         │
         ▼
[Hari 3 - Hari 5] SPRINT 2: Core Transaction Engine (Listing Baru, Detail, Klaim & Auto-Lock) (Arsha & Fajar)
         │
         ▼
[Hari 6 - Hari 7] SPRINT 3: Admin Moderasi, Seeder Demo Checkpoint, Hardening & UAT Sign-Off (Gebrian, Fajar, Arsha)
```

---

# 🚀 SPRINT 1: Foundation, Custom Auth & Katalog Barang
**Periode:** Hari 1 – Hari 2  
**Target:** Fondasi layout responsif, registrasi khusus mahasiswa ber-NIM, halaman beranda interaktif, dan katalog pencarian barang multi-filter.

### Task 1: Scaffolding, Layout Dasar & Navigasi Kampus
* **Target Selesai:** Hari 1
* **PIC:** Fajar Maulana (fajar)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `frontend-ui-engineering`
* **Status:** `[x] Selesai (20 Nov 2026)`
- [x] Kustomisasi konfigurasi Tailwind CSS (warna Emerald, Amber, Teal, Font Inter)
- [x] Layout master `resources/views/layouts/app.blade.php` dan `guest.blade.php`
- [x] Navigasi desktop & mobile dengan status aktif (`navigation.blade.php`)
- [x] Footer informatif dengan identitas waris.in (`footer.blade.php`)

### Task 2: Modul Autentikasi Mahasiswa & Registrasi Kampus
* **Target Selesai:** Hari 1–2
* **PIC:** Fajar Maulana (fajar)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `security-and-hardening`
* **Status:** `[x] Selesai (20 Nov 2026)`
- [x] Skema migrasi `users` dengan atribut mahasiswa (NIM, Fakultas, Angkatan, WhatsApp, Status)
- [x] Controller `RegisteredUserController` dengan validasi data mahasiswa
- [x] Desain halaman registrasi khusus (`resources/views/auth/register.blade.php`)
- [x] Desain halaman login (`resources/views/auth/login.blade.php`)

### Task 3: Modul Beranda & Katalog Jelajahi Barang
* **Target Selesai:** Hari 2
* **PIC:** Fajar Maulana & Arsha
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `frontend-ui-engineering`, `impeccable`
* **Status:** `[x] Selesai 90% (20 Nov 2026)`
- [x] Controller `HomeController` untuk halaman beranda & jejak kebaikan
- [x] Controller `ItemController@index` dengan multi-filter (kategori, mode, fakultas, kondisi)
- [x] Tampilan Hero Beranda & 3 Kartu Mode Transaksi (Gratis, Pas, Barter)
- [x] Komponen kartu barang `components/item-card.blade.php`
- [x] Halaman katalog barang `resources/views/items/index.blade.php`

---

# ⚡ SPRINT 2: Core Transaction Engine (Listing, Detail & Klaim/Barter)
**Periode:** Hari 3 – Hari 5  
**Target:** Mahasiswa dapat melihat detail lengkap barang, mengunggah barang baru dengan input harga bersyarat, mengelola barang miliknya, serta mengajukan dan menyetujui klaim/barter dengan fitur auto-lock.

### Task 4: Halaman Detail Barang & Galeri Foto (`items.show`)
* **Target Selesai:** Hari 3
* **PIC:** Arsha (arsha)
* **Reviewer:** Fajar Maulana (fajar)
* **Skill Rekomendasi:** `frontend-ui-engineering`, `impeccable`
* **Status:** `[ ] Siap Dikerjakan (Prioritas 1)`
- [ ] Buat method `show` di `ItemController.php` beserta query eager loading (`user`, `images`)
- [ ] Rancang view `resources/views/items/show.blade.php` dengan galeri foto, badge status, info spesifikasi barang, catatan kondisi, dan rencana titik temu kampus
- [ ] Implementasi tombol aksi kondisional (Pemilik: "Kelola Pengajuan", Mahasiswa Lain: "Ajukan Klaim / Barter", Jika Locked: Tampilkan badge terkunci)
- [ ] Verifikasi rendering halaman detail untuk ketiga mode transaksi

### Task 5: Formulir Pasang Barang Dinamis & Upload Foto (`items.create` & `items.store`)
* **Target Selesai:** Hari 3–4
* **PIC:** Arsha (arsha)
* **Reviewer:** Fajar Maulana (fajar)
* **Skill Rekomendasi:** `frontend-ui-engineering`, `antislop-ui`
* **Status:** `[x] Selesai & Terverifikasi`
- [x] Buat Form Request `ItemStoreRequest` / validasi ketat pada controller
- [x] Rancang view `resources/views/items/create.blade.php` dengan interaktivitas Alpine.js (4 langkah progresif, preview dinamis)
  - [x] Field nominal harga otomatis muncul dan bersinar HANYA jika mode = "Harga Pas"
  - [x] Field nominal harga otomatis disembunyikan/dikosongkan jika mode = "Gratis" atau "Barter" (FR-04)
  - [x] Field spesifikasi barang penukar muncul saat mode = "Barter"
  - [x] Preview foto barang sebelum upload
- [x] Implementasi method `ItemController@store` untuk simpan item & upload multiple image ke storage
- [x] Verifikasi bahwa harga tersimpan `null` saat mode Gratis/Barter

### Task 6: Manajemen Barang Saya (`items.my`, edit, update, delete)
* **Target Selesai:** Hari 4
* **PIC:** Arsha (arsha)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `security-and-hardening`, `frontend-ui-engineering`
* **Status:** `[x] Selesai & Terverifikasi`
- [x] Proteksi otorisasi memastikan hanya pemilik yang bisa mengedit/menghapus barangnya
- [x] Buat method `myItems`, `edit`, `update`, `destroy` pada `ItemController`
- [x] Rancang antarmuka `resources/views/items/my-items.blade.php` dengan ringkasan statistik dan indikator jumlah pengajuan masuk
- [x] Rancang view `resources/views/items/edit.blade.php`
- [x] Verifikasi proteksi otorisasi: user tidak dapat mengedit barang milik orang lain

### Task 7: Alur Pengajuan Klaim & Tawaran Barter (`claims.store`)
* **Target Selesai:** Hari 4–5
* **PIC:** Arsha (UI Modal) & Fajar Maulana (Backend Service)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `api-and-interface-design`, `antislop-layoutmobile`
* **Status:** `[x] Selesai & Terverifikasi`
- [x] Buat `ClaimController` dan method `store`
- [x] Rancang modal pop-up interaktif pada `items/show.blade.php` untuk kirim permohonan klaim / detail barang barter
- [x] Proteksi backend: tolak klaim atas barang sendiri dan cegah spam klaim ganda dari user yang sama
- [x] Verifikasi pengajuan berhasil masuk ke tabel `claims` dengan status `pending`

### Task 8: Dashboard Pengajuan Masuk & Approval Locking Atomic
* **Target Selesai:** Hari 5
* **PIC:** Fajar Maulana (Engine Lock) & Arsha (UI)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `test-driven-development`, `security-and-hardening`
* **Status:** `[x] Selesai & Terverifikasi`
- [x] Rancang view `resources/views/claims/incoming.blade.php` untuk pemilik barang memantau seluruh peminat
- [x] Implementasi method `ClaimController@approve` dengan `DB::transaction()` & `lockForUpdate()`:
  - [x] Ubah status klaim terpilih menjadi `approved`
  - [x] Ubah status barang menjadi `locked`
  - [x] Ubah otomatis seluruh klaim pending lainnya untuk barang tersebut menjadi `rejected`
- [x] Buka informasi kontak peminat yang disetujui (FR-09) dengan direct link ke WhatsApp
- [x] Verifikasi UAT: automated test `ClaimTransactionTest` memastikan konsistensi data terjamin 100%

### Task 9: Dashboard Pengajuan Saya & Unlocked Contact (`claims.my`)
* **Target Selesai:** Hari 5
* **PIC:** Arsha (arsha)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `frontend-ui-engineering`
* **Status:** `[x] Selesai & Terverifikasi`
- [x] Buat method `ClaimController@myClaims`
- [x] Rancang view `resources/views/claims/my-claims.blade.php` untuk memantau status seluruh permohonan
- [x] Tampilkan informasi kontak pemilik barang & lokasi pertemuan ketika status pengajuan berubah menjadi `approved`
- [x] Verifikasi pembaruan status dari kacamata peminat

---

# 🛡️ SPRINT 3: Admin Moderasi, Seeder Demo & UAT Sign-Off
**Periode:** Hari 6 – Hari 7  
**Target:** Pengawasan platform oleh admin kampus, penyediaan checkpoint seeder lengkap untuk demo dosen, serta verifikasi menyeluruh end-to-end.

### Task 10: Modul Admin Moderasi (Hapus Listing & Suspend Akun)
* **Target Selesai:** Hari 6
* **PIC:** Fajar Maulana (fajar)
* **Reviewer:** Gebrian (gebrian)
* **Skill Rekomendasi:** `security-and-hardening`
* **Status:** `[ ] Menunggu Sprint 2`
- [ ] Buat Middleware `EnsureAdmin` dan daftarkan di `bootstrap/app.php`
- [ ] Buat Middleware `EnsureNotSuspended` untuk menolak akses akun yang disuspend
- [ ] Rancang `AdminController` dan view `resources/views/admin/dashboard.blade.php`
- [ ] Fitur hapus paksa (*force delete*) listing barang yang melanggar aturan (FR-10)
- [ ] Fitur suspend akun pengguna beserta alasan penangguhan (FR-11)
- [ ] Verifikasi bahwa akun yang di-suspend tidak dapat login kembali

### Task 11: Seeder Checkpoint Realistis untuk Presentasi Demo
* **Target Selesai:** Hari 6
* **PIC:** Gebrian (gebrian) & Fajar Maulana (fajar)
* **Reviewer:** Arsha (arsha)
* **Skill Rekomendasi:** `code-review-and-quality`
* **Status:** `[ ] Menunggu Sprint 2`
- [ ] Sempurnakan `database/seeders/DatabaseSeeder.php` dengan data realistis mahasiswa beragam fakultas
- [ ] Tambahkan minimal 12 data barang perkuliahan (kategori buku, alat praktikum, jas lab, jaket, elektronik)
- [ ] Buat contoh klaim yang sudah berstatus `approved` dan `locked` agar saat demo terlihat aktivitas sirkulasi yang hidup
- [ ] Verifikasi eksekusi `php artisan migrate:fresh --seed` berjalan mulus tanpa kendala

### Task 12: Pengujian UAT End-to-End & Demo Readiness Sign-Off
* **Target Selesai:** Hari 7
* **PIC:** Gebrian (gebrian) didukung Fajar & Arsha
* **Reviewer:** Seluruh Tim
* **Skill Rekomendasi:** `verification-before-completion`
* **Status:** `[ ] Menunggu Task 10 & 11`
- [ ] Eksekusi automated test `tests/Feature/ItemTransactionTest.php`
- [ ] Pengujian manual seluruh skenario: Registrasi $\rightarrow$ Pasang Barang $\rightarrow$ Cari $\rightarrow$ Klaim $\rightarrow$ Approve $\rightarrow$ Lock $\rightarrow$ Buka Kontak $\rightarrow$ Moderasi Admin
- [ ] Verifikasi tampilan mobile (responsive view)
- [ ] **Gerbang Evaluasi Final (Sign-Off):** Seluruh 11 kriteria PRD terpenuhi dan sistem 100% siap dipresentasikan di hadapan dosen penguji.
