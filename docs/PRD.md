# PRD — Platform Tukar Barang Kampus (nama belum fix jir)

**Nov 15, 2026 · @Fajar Maulana**

---

## 1. Overview

Platform web buat mahasiswa satu kampus saling kasih, tuker, atau jual murah barang kuliah yang udah nggak kepake — dibangun buat tugas akhir Pemrograman Web II (semester 7), tenggat 1 minggu. Vibe-nya santai, bukan e-commerce formal — lebih kayak "titip ke grup angkatan" tapi versi web.

| Atribut | Detail |
| :--- | :--- |
| **Nama produk** | Belum fix (kandidat: waris.in, dll) |
| **Jenis** | Aplikasi web (bukan mobile) |
| **Target pengguna** | Mahasiswa aktif satu kampus |
| **Tech stack** | PHP, Laravel, MySQL |
| **Tim** | 3 orang |
| **Durasi pengerjaan** | 1 minggu (versi MVP) |
| **Jumlah aktor** | 2 (Mahasiswa, Admin) |

---

## 2. Problem Statement

Banyak mahasiswa punya barang kuliah yang udah nggak kepake — buku semester lalu, alat praktikum, baju almamater kekecilan — tapi mager jual di marketplace umum (ribet ongkir, nego harga, ketemu orang asing). Di sisi lain, adik tingkat atau temen sekampus sering butuh barang yang sama persis. Selama ini solusinya cuma japri atau nitip di grup angkatan, yang gampang ketumpuk chat dan nggak ada histori yang jelas siapa duluan nawar. Platform ini bikin proses itu lebih rapi: listing, klaim, approve, selesai — tanpa ribet uang masuk ke sistem atau nego bertele-tele.

---

## 3. Goals & Success Metrics

* Mahasiswa bisa listing barang (gratis / harga pas / barter) dalam hitungan menit, tanpa form yang ribet
* Mahasiswa lain bisa klaim/ajukan barter dan langsung tau statusnya (kena approve atau nggak)
* Nggak ada drama "barang udah diambil orang lain tapi masih keliatan available" — begitu di-approve, listing langsung lock
* Sistem jalan end-to-end tanpa error pas demo ke dosen, selesai dikerjain dalam 1 minggu oleh tim 3 orang

---

## 4. User Roles / Actors

| Peran | Deskripsi | Kemampuan Utama |
| :--- | :--- | :--- |
| **Mahasiswa** | Semua user kampus, bisa gantian jadi pemilik barang atau peminat — cuma 1 jenis akun | Daftar/login, listing barang (pilih mode: Gratis / Harga Pas / Barter), browse listing orang lain, ajukan klaim/barter, approve salah satu pengajuan masuk |
| **Admin** | Pengelola platform (bisa dirangkap anggota tim), kewenangan minimal — bukan sistem moderasi penuh | Hapus listing yang melanggar aturan, suspend/banned akun bermasalah |

---

## 5. Scope

### In-Scope (wajib, MVP 1 minggu)
* Registrasi & login dengan validasi email pribadi
* Listing barang: judul, deskripsi, kondisi, foto, dropdown mode (Gratis / Harga Pas / Barter), field kontak bebas teks
* Field nominal harga cuma aktif/muncul kalau mode "Harga Pas" dipilih
* User lain ajukan klaim (kalau Gratis/Harga Pas) atau tawaran barter (kalau mode Barter)
* Pemilik approve salah satu pengajuan — approve pertama langsung lock, sisanya otomatis batal
* Info kontak peminat yang di-approve terbuka ke pemilik setelah approve
* Admin: halaman sederhana buat hapus listing & suspend akun

### Out-of-Scope (dipotong dulu, bisa jadi pengembangan lanjutan)
* Chat real-time di dalam web (kontak cuma field teks biasa)
* Sistem tawar-menawar / counter-offer harga
* Penjadwalan COD formal + konfirmasi dua langkah di dalam app
* Sistem laporan, mediasi, atau sanksi berjenjang
* Dashboard admin dengan analitik/SLA
* Payment gateway, saldo, atau wallet apa pun
* Generate PDF bukti transaksi otomatis

---

## 6. Functional Requirements

| ID | Modul | Deskripsi | Prioritas |
| :--- | :--- | :--- | :--- |
| **FR-01** | Auth | Mahasiswa daftar pakai email pribadi (kampus tidak menyediakan domain email khusus mahasiswa) | Wajib |
| **FR-02** | Auth | Mahasiswa login & logout | Wajib |
| **FR-03** | Listing | User bikin listing baru (judul, deskripsi, kondisi, foto, mode, kontak) | Wajib |
| **FR-04** | Listing | Field nominal harga aktif hanya kalau mode "Harga Pas" dipilih | Wajib |
| **FR-05** | Browse | User lihat katalog listing & halaman detail barang | Wajib |
| **FR-06** | Klaim | User ajukan klaim (Gratis/Harga Pas) atau tawaran barter (mode Barter) ke listing orang lain | Wajib |
| **FR-07** | Approve | Pemilik lihat semua pengajuan masuk & approve salah satu | Wajib |
| **FR-08** | Sistem | Approve pertama mengunci listing (status locked), pengajuan lain otomatis ditolak | Wajib |
| **FR-09** | Kontak | Info kontak peminat yang di-approve terbuka ke pemilik setelah approve | Wajib |
| **FR-10** | Admin | Admin bisa menghapus listing yang melanggar | Wajib |
| **FR-11** | Admin | Admin bisa suspend/banned akun bermasalah | Wajib |

---

## 7. Non-Functional Requirements

* **Keamanan:** password di-hash (bawaan Laravel)
* **Platform:** web responsive, bisa diakses dari browser desktop maupun mobile
* **Database:** MySQL, pakai migration Laravel biar skema gampang direplikasi antar anggota tim
* **Kerja tim:** modul dipisah per controller/folder biar 3 orang bisa ngerjain paralel tanpa saling tabrakan
* **Tone & bahasa produk:** santai dan modern, hindari istilah formal/berat (hindari kata kayak "hibah", "waris", pakai istilah kasual kayak "gratisin", "harga pas")

---

## 8. User Flow

1. Mahasiswa daftar pakai email pribadi, lalu login.
2. Upload barang: isi detail (judul, deskripsi, kondisi, foto), pilih mode (Gratis / Harga Pas / Barter), isi field kontak bebas teks.
3. Kalau pilih "Harga Pas", field nominal otomatis bisa diisi; kalau Gratis/Barter, field itu nonaktif.
4. User lain browse katalog, buka detail barang yang diminati.
5. User lain ajukan klaim (Gratis/Harga Pas) atau tawaran barter (sebutin barang yang mau ditukar).
6. Pemilik barang lihat semua pengajuan yang masuk di satu halaman.
7. Pemilik approve salah satu — begitu di-approve, listing langsung berstatus "locked" dan pengajuan lain otomatis batal.
8. Info kontak (WA/IG/dll, ditulis sendiri oleh peminat) terbuka ke pemilik, lanjut nego/ketemuan di luar sistem.

---

## 9. Data Model Ringkas

| Tabel | Kolom Penting | Keterangan |
| :--- | :--- | :--- |
| **users** | `name`, `email`, `role`, `status` | `role`: mahasiswa/admin; `status`: active/suspended |
| **items** | `user_id`, `title`, `description`, `condition`, `mode`, `price`, `contact_info`, `status` | `mode`: gratis/harga_pas/barter; `price` nullable (cuma keisi kalau mode harga_pas); `status`: available/locked |
| **item_images** | `item_id`, `image_path` | Foto-foto barang (bisa lebih dari satu) |
| **claims** | `item_id`, `claimant_id`, `offered_item_desc`, `status` | `offered_item_desc` cuma keisi kalau klaimnya barter; `status`: pending/approved/rejected |

---

## 10. Constraints & Assumptions

* Nggak ada uang yang "masuk" ke sistem sama sekali — transaksi "Harga Pas" cuma nominal kesepakatan yang dibayar langsung pas ketemuan
* Approve pertama langsung lock — dipilih biar logikanya simpel, nggak perlu sistem antrean cadangan atau nego berlapis
* Field kontak sengaja bebas teks (bukan field khusus WhatsApp/dll) biar fleksibel dan gampang dikerjain
* Kewenangan admin dibatasi ke hapus listing & suspend akun — sengaja nggak dibikin sistem moderasi/mediasi penuh biar nggak makan waktu
* Data checkpoint/contoh listing disiapkan lewat seeder biar demo nggak nampilin halaman kosong
* Nggak ada domain email khusus kampus, jadi registrasi pakai email pribadi apa aja — verifikasi keaslian mahasiswa (kalau diperlukan) cukup manual, misal minta isi NIM saat daftar, bukan validasi otomatis lewat domain

---

## 11. Timeline (7 Hari · 4 Fase, 1 Fase Paralel)

Setup bersama di Hari 1, lalu 3 modul dikerjakan paralel sepanjang Hari 2–5, digabung di Hari 6, dan diuji sebelum demo di Hari 7.

```
┌──────────────────┐     ┌──────────────────────────────────┐     ┌──────────────────┐     ┌──────────────────┐
│   Setup Hari 1   │ ──> │       Development Hari 2-5       │ ──> │ Integrasi Hari 6 │ ──> │Testing & Demo Hr7│
│                  │     │ Modul 1: Auth & Admin            │     │                  │     │                  │
│ Migration        │     │ Modul 2: Driver (Owner/Listing)  │     │ Gabung 3 modul   │     │ Uji alur end-to- │
│ Seeder checkpoint│     │ Modul 3: Penumpang (Claim/Browse)│     │ Perbaikan bug    │     │   end            │
│                  │     │ (paralel, 1 org/modul)           │     │                  │     │ Siapkan demo &   │
│                  │     │                                  │     │                  │     │   laporan        │
└──────────────────┘     └──────────────────────────────────┘     └──────────────────┘     └──────────────────┘
```

---

## 12. Acceptance Criteria

- [ ] Mahasiswa bisa daftar pakai email pribadi, lalu login
- [ ] User bisa bikin listing dengan 3 pilihan mode, dan field harga cuma nyala pas pilih "Harga Pas"
- [ ] User lain bisa lihat katalog & ajukan klaim/barter ke listing yang diminati
- [ ] Approve pertama langsung lock listing, pengajuan lain otomatis ketolak
- [ ] Info kontak peminat yang di-approve muncul ke pemilik
- [ ] Admin bisa hapus listing & suspend akun lewat halaman sederhana
- [ ] Seeder jalan sehingga katalog nggak kosong pas demo
- [ ] Seluruh alur di atas bisa dijalankan tanpa error fatal saat demo ke dosen.
