# 📦 waris.in — Platform Tukar & Hibah Barang Kampus
## Product Requirement Document (PRD)

> **Versi Dokumen:** 1.0 (MVP)  
> **Tanggal:** 15 November 2026  
> **Author:** Fajar Maulana (@Fajar Maulana)  
> **Konteks:** Tugas Akhir Mata Kuliah Pemrograman Web II (Semester 7)  
> **Target Pengerjaan:** 1 Minggu (MVP Demo Ready)  

---

## 1. Overview

**waris.in** adalah platform web bagi mahasiswa satu kampus untuk saling menghibahkan (gratis), menukar (barter), atau menjual murah (harga pas) perlengkapan dan barang kuliah yang sudah tidak terpakai. 

Platform ini dirancang dengan suasana santai, kasual, dan ramah mahasiswa — bukan e-commerce formal berskala nasional. Konsep utamanya menyerupai "titip jual/hibah ke grup angkatan", namun ditata dalam sistem web terstruktur dengan status inventaris yang jelas, transparan, dan realtime.

| Atribut | Detail |
| :--- | :--- |
| **Nama Produk** | waris.in *(Kandidat resmi yang disepakati)* |
| **Jenis Platform** | Aplikasi Web Responsif (Desktop & Mobile Browser) |
| **Target Pengguna** | Mahasiswa aktif dalam satu kampus |
| **Tech Stack** | PHP 8.3+, Laravel 13, Tailwind CSS, Alpine.js, Blade Components, MySQL |
| **Tim Pengembang** | 3 Orang (Fajar Maulana, Arsha, Gebrian) |
| **Durasi Pengerjaan** | 1 Minggu (Versi MVP) |
| **Jumlah Aktor** | 2 Aktor: Mahasiswa & Admin Kampus |

---

## 2. Problem Statement

1. **Barang Kuliah Menganggur:** Banyak mahasiswa memiliki barang kuliah yang tidak lagi terpakai (buku teks semester lalu, jas praktikum, kalkulator scientific, alat gambar arsitektur, kemeja sidang/almamater yang kekecilan).
2. **Friksi Marketplace Umum:** Mahasiswa enggan menjual di marketplace nasional umum karena repot biaya ongkos kirim, potongan komisi platform, tawar-menawar harga yang alot, serta risiko bertransaksi dengan orang asing.
3. **Kebutuhan Adik Tingkat / Teman Sekampus:** Mahasiswa baru atau adik tingkat sering kali membutuhkan barang-barang perkuliahan yang sama persis setiap pergantian semester.
4. **Kelemahan Grup Chat / Komunitas:** Solusi konvensional selama ini (titip chat di grup WhatsApp / LINE angkatan atau Twitter kampus) cepat tenggelam oleh obrolan lain, tidak memiliki katalog terpusat, dan menimbulkan ketidakjelasan siapa yang lebih dulu mengajukan penawaran.

**Solusi waris.in:**  
Menghadirkan alur transaksi sederhana dan transparan: **Listing $\rightarrow$ Klaim / Ajukan Barter $\rightarrow$ Approve Pemilik $\rightarrow$ Kunci Status $\rightarrow$ Selesai (Temuan/COD Mandiri)** tanpa perantara uang ke sistem rekening bersama.

---

## 3. Goals & Success Metrics

* **Cepat & Ringkas:** Mahasiswa dapat memasang listing barang (mode Gratis, Harga Pas, atau Barter) dalam hitungan menit tanpa formulir rumit.
* **Transparansi Status:** Peminat langsung mengetahui status pengajuannya (apakah diterima atau ditolak oleh pemilik barang).
* **Zero Inventory Conflict:** Tidak ada insiden barang sudah diambil orang lain namun statusnya masih bertuliskan "tersedia" — saat pemilik meng-approve satu peminat, listing langsung berstatus **Locked** dan pengajuan lainnya otomatis gugur/ditolak.
* **Demo-Ready Stability:** Sistem berjalan stabil secara *end-to-end* tanpa error fatal saat dipresentasikan di hadapan dosen penguji.

---

## 4. User Roles & Actors

| Peran (Role) | Deskripsi | Kemampuan Utama |
| :--- | :--- | :--- |
| **Mahasiswa** | Seluruh civitas akademika kampus yang terdaftar. Akun bersifat fleksibel: satu akun dapat bertindak sebagai pemilik barang (*giver/seller*) maupun peminat (*claimant/buyer*). | - Registrasi akun & login (menggunakan email pribadi & NIM)<br>- Menjelajahi katalog barang dengan filter & pencarian<br>- Memasang listing barang baru (Gratis / Harga Pas / Barter)<br>- Mengajukan klaim atau tawaran barter ke barang orang lain<br>- Menyetujui (*approve*) salah satu pengajuan masuk<br>- Melihat kontak peminat yang disetujui untuk janjian COD |
| **Admin Kampus** | Pengelola platform (dapat dirangkap oleh tim pengembang) dengan wewenang pengawasan minimal. | - Memantau seluruh listing di sistem<br>- Menghapus listing yang melanggar ketentuan/konten tidak pantas<br>- Menangguhkan (*suspend/ban*) akun pengguna yang bermasalah |

---

## 5. Scope & Boundary

### 5.1 In-Scope (Wajib untuk MVP 1 Minggu)
1. **Autentikasi Akun:** Registrasi dan login mahasiswa menggunakan email pribadi dan validasi NIM (kampus tidak menyediakan domain email khusus mahasiswa).
2. **Listing Barang Dinamis:** Formulir pembuatan listing meliputi judul, kategori, kondisi barang, catatan kondisi, foto barang, mode transaksi (Gratis / Harga Pas / Barter), lokasi pertemuan kampus, dan informasi kontak bebas teks.
3. **Conditional Price Input:** Input nominal harga hanya aktif dan wajib diisi apabila mode "Harga Pas" dipilih; dinonaktifkan (null) pada mode "Gratis" dan "Barter".
4. **Katalog & Detail Barang:** Tampilan katalog dengan filter kategori, fakultas, kondisi, dan mode, dilengkapi halaman detail barang lengkap dengan galeri foto.
5. **Pengajuan Klaim / Barter:** Mahasiswa lain dapat mengajukan permohonan klaim barang (mode Gratis/Harga Pas) atau menuliskan deskripsi barang tawaran barter (mode Barter).
6. **Mekanisme Approval & Auto-Lock:** Pemilik barang melihat daftar pengajuan masuk dan memilih satu yang disetujui. Approval pertama langsung mengunci status listing menjadi **Locked**, menolak pengajuan peminat lain secara otomatis.
7. **Pertukaran Kontak Pasca-Approve:** Nomor kontak (WhatsApp/ID Telegram/nomor telepon) peminat yang disetujui terbuka ke pemilik barang agar dapat melanjutkan komunikasi di luar sistem.
8. **Moderasi Admin Sederhana:** Halaman admin untuk menghapus listing bermasalah dan menangguhkan (*suspend*) akun mahasiswa nakal.
9. **Checkpoint Seeder Data:** Dataset contoh lengkap (barang praktikum, buku teks, jas lab, akun mahasiswa & admin) agar katalog siap didemokan.

### 5.2 Out-of-Scope (Dikecualikan / Rilis Masa Depan)
* Fitur *in-app chat real-time* (kontak cukup menggunakan pertukaran info kontak bebas teks untuk lanjut via WhatsApp).
* Sistem tawar-menawar harga bertingkat (*counter-offer negotiation*).
* Penjadwalan COD otomatis dua arah dengan validasi kode OTP.
* Integrasi *payment gateway*, dompet digital (*e-wallet*), atau saldo akun.
* Sistem sanksi berjenjang / pelaporan mediasi sengketa formal.
* Cetak struk / dokumen bukti transaksi dalam format PDF.

---

## 6. Functional Requirements (FR)

| ID | Modul | Deskripsi Kebutuhan Fungsional | Prioritas |
| :--- | :--- | :--- | :--- |
| **FR-01** | Auth | Mahasiswa dapat mendaftarkan akun baru dengan data: Nama, NIM, Email pribadi, Fakultas, Angkatan, Nomor WhatsApp, dan Password. | **Wajib (P0)** |
| **FR-02** | Auth | Mahasiswa dapat melakukan login, logout, dan manajemen sesi dengan aman. Akun berstatus `suspended` dilarang login. | **Wajib (P0)** |
| **FR-03** | Listing | Mahasiswa dapat mengunggah listing barang baru dengan menginput judul, deskripsi, kategori, kondisi, foto utama & foto pendukung, lokasi COD kampus, dan info kontak. | **Wajib (P0)** |
| **FR-04** | Listing | Form input harga bersifat bersyarat (*conditional*): hanya aktif dan wajib diisi saat mode "Harga Pas" dipilih; otomatis nonaktif (*disabled & null*) saat mode "Gratis" atau "Barter". | **Wajib (P0)** |
| **FR-05** | Katalog | Pengguna dapat melihat daftar katalog barang publik, menyaring berdasarkan mode, kategori, fakultas, serta membuka halaman detail barang. | **Wajib (P0)** |
| **FR-06** | Klaim | Mahasiswa (bukan pemilik) dapat mengajukan klaim untuk mode Gratis/Harga Pas atau mengajukan tawaran barang penukar untuk mode Barter. | **Wajib (P0)** |
| **FR-07** | Approval | Pemilik barang dapat melihat seluruh pengajuan masuk untuk barang miliknya pada dashboard khusus. | **Wajib (P0)** |
| **FR-08** | Sistem | Mekanisme *atomic approval*: menyetujui satu pengajuan seketika mengubah status barang menjadi `locked` dan menolak seluruh pengajuan lain yang berstatus `pending`. | **Wajib (P0)** |
| **FR-09** | Kontak | Informasi kontak peminat yang disetujui ditampilkan secara eksklusif kepada pemilik barang untuk koordinasi serah terima barang. | **Wajib (P0)** |
| **FR-10** | Admin | Admin dapat melihat seluruh daftar barang dan menghapus (*force delete/take down*) listing yang melanggar etika kampus. | **Wajib (P0)** |
| **FR-11** | Admin | Admin dapat menangguhkan (*suspend*) akun mahasiswa yang bermasalah beserta memberikan catatan alasan penangguhan. | **Wajib (P0)** |

---

## 7. Non-Functional Requirements (NFR)

* **Keamanan:** Penyimpanan kata sandi menggunakan hashing Bcrypt bawaan Laravel. Proteksi formulir dengan token CSRF. Autorisasi kepemilikan data menggunakan Laravel Policies.
* **Responsivitas Antarmuka:** Desain antarmuka beradaptasi mulus (*mobile-first*) pada layar ponsel pintar (360px) hingga layar monitor desktop (1920px).
* **Bahasa & Tone:** Nada bahasa kasual, ramah, dan santai khas mahasiswa. Menghindari kata kaku/formal seperti "hibah negara", "warisan", menggantinya dengan "gratisin", "harga pas", "barter".
* **Arsitektur Kode Terisolasi:** Controller dan view dipisahkan rapi per modul untuk mempermudah pengerjaan paralel tim tanpa benturan (*git merge conflict*).

---

## 8. Data Model & Skema Database

```text
users
├── id (PK)
├── name (string)
├── nim (string, unique)
├── email (string, unique)
├── password (string)
├── role (enum: 'mahasiswa', 'admin')
├── status (enum: 'active', 'suspended')
├── suspend_reason (text, nullable)
├── faculty (string, nullable)
├── batch (string, nullable)
├── phone (string, nullable)
├── avatar (string, nullable)
└── timestamps

items
├── id (PK)
├── user_id (FK -> users.id)
├── title (string)
├── category (string)
├── condition (string)
├── condition_note (string, nullable)
├── description (text)
├── mode (enum: 'gratis', 'harga_pas', 'barter')
├── price (unsigned int, nullable)
├── barter_request (string, nullable)
├── contact_info (text)
├── meetup_location (string, nullable)
├── time_handover (string, nullable)
├── status (enum: 'available', 'locked')
└── timestamps

item_images
├── id (PK)
├── item_id (FK -> items.id)
├── image_path (string)
├── is_primary (boolean, default: false)
└── timestamps

claims
├── id (PK)
├── item_id (FK -> items.id)
├── claimant_id (FK -> users.id)
├── contact_info (string)
├── message (text, nullable)
├── offered_item_desc (text, nullable)
├── status (enum: 'pending', 'approved', 'rejected')
└── timestamps
```

---

## 9. User Flow Utama

```
[Mahasiswa Login]
       │
       ├─────────────────────────────────┐
       ▼                                 ▼
[Upload Barang Baru]             [Jelajahi Katalog]
 - Judul & Deskripsi              - Filter Kategori / Mode
 - Pilih Mode (Gratis/Pas/Barter) - Buka Detail Barang
 - Upload Foto                    - Klik "Ajukan Klaim / Barter"
 - Info Kontak & Lokasi Kampus    - Kirim Kontak & Deskripsi Tawaran
       │                                 │
       ▼                                 ▼
[Status Listing: AVAILABLE]       [Status Klaim: PENDING]
       │                                 │
       └────────────────┬────────────────┘
                        ▼
            [Pemilik Buka Pengajuan]
                        │
                        ▼
            [Klik Approve pada 1 Peminat]
                        │
         ┌──────────────┴──────────────┐
         ▼                             ▼
  [Status Pengajuan:            [Listing Berubah:
     APPROVED]                       LOCKED]
         │                             │
         ▼                             ▼
  [Kontak Peminat               [Pengajuan Peminat Lain:
   Terbuka ke Pemilik]           Otomatis REJECTED]
         │
         ▼
  [Janjian COD di Kampus]
```
