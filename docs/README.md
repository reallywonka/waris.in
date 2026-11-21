# 📚 waris.in — Dokumentasi Resmi Proyek

Selamat datang di pusat dokumentasi resmi **waris.in** (Platform Tukar & Hibah Barang Mahasiswa Kampus). Proyek ini dibangun menggunakan **Laravel 13**, **Tailwind CSS**, **Alpine.js**, dan **MySQL** untuk memenuhi tugas besar mata kuliah **Pemrograman Web II (Semester 7)**.

---

## 📌 Dokumen Utama

| Dokumen | Deskripsi | Tautan File |
| :--- | :--- | :--- |
| **Product Requirement Document (PRD)** | Spesifikasi lengkap platform, 2 aktor (Mahasiswa & Admin), 11 kebutuhan fungsional (FR-01 s/d FR-11), batasan MVP 1 minggu, skema basis data, dan aturan interaksi. | [`docs/PRD.md`](./PRD.md) |
| **Technical Implementation Plan** | Rincian arsitektur teknis, daftar 12 task dengan spesifikasi file (Create/Modify), interfaces/kontrak controller, skenario uji, serta alur pengerjaan modular per developer. | [`docs/IMPLEMENTATION_PLAN.md`](./IMPLEMENTATION_PLAN.md) |
| **Sprint Roadmap & Work Breakdown** | Roadmap 3 Sprint (1 minggu pengerjaan menuju demo ke dosen), pembagian RACI tim (Fajar Maulana, Arsha, Gebrian), pemetaan skills terpasang, dan checklist progres harian. | [`docs/SPRINT.md`](./SPRINT.md) |

---

## 👥 Tim Pengembang & Pembagian Tugas (Mapping Peran)

Sesuai pembagian peran pada standar proyek referensi:

| Anggota Tim | Mapping Peran Acuan | Posisi & Peran Utama | Tanggung Jawab Utama |
| :--- | :--- | :--- | :--- |
| **Fajar Maulana** | *Revan* | **Lead Project & Backend Engineer** | Arsitektur skema database & migrasi, core controllers, logic approval & auto-lock atomik, auth customization, dan modul admin moderasi. |
| **Arsha** | *Aufa* | **Full-Stack & Frontend UI Engineer** | Blade views, desain Tailwind CSS bertema hijau kampus, dynamic modal input, formulir bersyarat (conditional price), katalog, detail barang, dan interaktivitas user. |
| **Gebrian** | *Egi* | **Project Manager & QA Engineer** | Sprint tracking, backlog grooming, penyusunan test case, verifikasi UAT end-to-end, seeding data demo realistis, dan dokumentasi release. |

---

## 🤖 Aturan Wajib untuk AI Agent (AI Agent Guidelines)

Seluruh AI coding assistant / agent yang berkontribusi pada repositori ini **wajib membaca dan mematuhi** isi dokumen dalam folder `docs/` ini sebelum membuat kode atau merancang perubahan fitur:
1. **Branch Hygiene:** Selalu pastikan bekerja di branch fitur / branch pengembang (misalnya `dev-arsha`) sebelum melakukan eksekusi kode.
2. **Modular Architecture:** Pisahkan controller, form request, dan view per modul agar pengerjaan bersama 3 anggota tim tidak menimbulkan benturan (*merge conflict*).
3. **Strict Non-Scope:** Patuhi batasan MVP pada PRD — jangan menambahkan payment gateway, in-app chat, atau multi-step COD yang memakan waktu sebelum fitur inti (FR-01 s/d FR-11) selesai teruji secara penuh.
