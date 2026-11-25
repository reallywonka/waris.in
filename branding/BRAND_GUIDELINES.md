# Panduan Identitas Brand — waris.in (Brand Guidelines)

> **Ringkasan Cepat:** Dokumen pedoman visual dan teknis resmi untuk identitas logo **waris.in** (Platform Tukar & Hibah Barang Mahasiswa Kampus).

---

## 1. Filosofi Logo: "Kotak Berbagi" (The Handover Box)

* **Konsep Inti:** Siluet kotak paket/wadah barang yang terbuka membentuk inisial huruf **W** sekaligus menyiratkan gestur sepasang telapak tangan yang saling menyambut dan mengoper barang preloved kuliah.
* **Aksen Pusat (*Gift Spark*):** Bintang berlian empat sudut di tengah melambangkan nilai kebermanfaatan barang yang diwariskan dari satu generasi mahasiswa ke generasi berikutnya.
* **Pesan Utama:** Akrab, solutif, sirkular (ramah lingkungan & hemat), dan tepercaya.

---

## 2. Struktur Versi Logo & Penggunaan

| Versi | Deskripsi | Rekomendasi Penempatan |
| :--- | :--- | :--- |
| **Horizontal Primary Lockup** | Simbol + Wordmark `waris.in` | Header website, invoice, kop dokumen, banner horizontal |
| **Stacked Lockup** | Simbol di atas + Wordmark di bawah | Tas *tote bag*, merchandise, spanduk vertikal, *event badge* |
| **Standalone Symbol** | Simbol W saja | *Favicon* browser, avatar profil media sosial, *app icon* PWA |
| **Monochrome Black** | 100% Hitam murni | Dokumen fotokopi, stempel kampus, media cetak satu warna |
| **Reversed White** | 100% Putih murni | Latar belakang gelap, tema malam (*dark mode*), video *overlay* |

---

## 3. Ruang Bebas (Clear Space) & Ukuran Minimum

### Clear Space (Zona Aman)
* Pertahankan jarak bebas di sekeliling logo sebesar **$1X$**, di mana **$X$** adalah tinggi elemen *Gift Spark* (berlian oranye di tengah simbol).
* Tidak boleh ada teks, foto, border, atau elemen grafis lain yang menabrak area zona aman ini.

### Ukuran Minimum (Minimum Sizes)
* **Horizontal Lockup:**
  * Digital / Layar: Minimal lebar **96 px** (tinggi proporsional ~32 px).
  * Cetak: Minimal lebar **28 mm**.
* **Standalone Symbol:**
  * Digital / Layar: Minimal **16 px × 16 px** (gunakan file varian `waris-symbol-small.svg` atau `favicon-16.png`).
  * Cetak: Minimal **6 mm × 6 mm**.

---

## 4. Palet Warna Resmi (Brand Colors)

| Peran | Nama Warna | Nilai HEX | Nilai RGB | Nilai CMYK | Makna Filosofis |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Primary** | **Campus Emerald** | `#047857` | `rgb(4, 120, 87)` | `97, 0, 28, 53` | Segar, kampus, sirkularitas ramah lingkungan, pertumbuhan |
| **Secondary** | **Deep Pine** | `#065F46` | `rgb(6, 95, 70)` | `94, 0, 26, 63` | Kedalaman lipatan kotak, stabilitas, rasa aman transaksi |
| **Accent** | **Warm Amber** | `#D97706` | `rgb(217, 119, 6)` | `0, 45, 97, 15` | Kehangatan, energi mahasiswa, nilai berharga dari barang warisan |
| **Dark Neutral** | **Slate Ink** | `#0F172A` | `rgb(15, 23, 42)` | `64, 45, 0, 84` | Ketegasan tipografi, keterbacaan tinggi di layar |
| **Light Neutral**| **Pure White** | `#FFFFFF` | `rgb(255, 255, 255)`| `0, 0, 0, 0` | Kebersihan dan keterbukaan antarmuka |

---

## 5. Tipografi (Typography)

* **Wordmark `waris.in`:** Dikonstruksi khusus (*custom geometric vector curves*) berbasis proporsi geometris sans-serif modern dengan sudut kurva yang serasi dengan lengkungan simbol.
* **Teks Antarmuka Web & Produk:**
  * **Primer:** `Plus Jakarta Sans` / `Inter` (Font sans-serif modern berlisensi Google Open Font).
  * **Fallback Sistem:** `ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`.

---

## 6. Pantangan Penggunaan (Misuse / Don'ts)

1. **Dilarang mendistorsi proporsi:** Jangan memanjangkan (*stretch*) atau memipihkan (*squash*) logo.
2. **Dilarang memisahkan/menggeser elemen:** Posisi *Gift Spark* amber di tengah kotak tidak boleh digeser atau diubah ukurannya secara independen.
3. **Dilarang mengganti warna di luar palet:** Jangan menggunakan gradien pelangi, efek drop-shadow 3D jadul, bevel, atau neon glow.
4. **Dilarang menempatkan di atas foto yang kontrasnya ramai:** Gunakan kontainer putih atau gunakan versi *reversed white* dengan latar kontras tinggi.
5. **Dilarang mengetik ulang wordmark dengan font sembarang:** Selalu gunakan file vektor master (`.svg`) yang sudah disediakan.

---

## 7. Direktori Berkas Aset (Asset Manifest)

Semua file produksi telah disiapkan di folder `branding/`:
* **Vektor Master:**
  * `waris-symbol.svg` — Simbol utama full color
  * `waris-symbol-small.svg` — Cut khusus ukuran mikro (16-32 px)
  * `waris-horizontal.svg` — Lockup horizontal resmi
  * `waris-stacked.svg` — Lockup vertikal resmi
  * `waris-symbol-white.svg` & `waris-horizontal-white.svg` — Versi monokrom putih
* **Paket Ikon Web & PWA (`branding/dist/`):**
  * `favicon.ico`, `favicon.svg`, `favicon-16.png`, `favicon-32.png`, `favicon-48.png`
  * `apple-touch-icon.png` (180×180)
  * `icon-192.png`, `icon-512.png`, `maskable-512.png`
  * `site.webmanifest` & `head-snippet.html`
* **Presentasi & Mockup:**
  * `presentation.html` — Interactive Client Presentation Board
  * `slides/slide-01.png` s/d `slide-05.png` — High-res mockup render slides
