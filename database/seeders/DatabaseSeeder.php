<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Rating;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Mahasiswa & Admin)
        $admin = User::create([
            'name' => 'Admin Kampus',
            'nim' => 'ADMIN001',
            'email' => 'admin@waris.in',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'faculty' => 'Direktorat Kemahasiswaan',
            'study_program' => 'Administrasi Kampus',
            'semester' => 8,
            'batch' => 'Pengelola',
            'phone' => '081100001111',
            'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=200',
        ]);

        $andi = User::create([
            'name' => 'Andi Pratama',
            'nim' => '13521098',
            'email' => 'andi.pratama@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Fasilkom',
            'study_program' => 'Teknik Informatika',
            'semester' => 5,
            'batch' => '2022',
            'phone' => '0812-3456-7890',
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=200',
        ]);

        $siti = User::create([
            'name' => 'Siti Rahma',
            'nim' => '14122045',
            'email' => 'sitirahma.apt@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Farmasi',
            'study_program' => 'Farmasi Klinis',
            'semester' => 5,
            'batch' => '2022',
            'phone' => '0812-9876-5432',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=200',
        ]);

        $dimas = User::create([
            'name' => 'Dimas Saputra',
            'nim' => '12021034',
            'email' => 'dimas.saputra99@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Teknik Mesin',
            'study_program' => 'Teknik Mesin',
            'semester' => 7,
            'batch' => '2021',
            'phone' => '0813-1122-3344',
            'avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&q=80&w=200',
        ]);

        $nabila = User::create([
            'name' => 'Nabila Putri',
            'nim' => '15023012',
            'email' => 'nabila.putri@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Ilmu Hukum',
            'study_program' => 'Ilmu Hukum',
            'semester' => 3,
            'batch' => '2023',
            'phone' => '0821-1122-3344',
            'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=200',
        ]);

        $rizky = User::create([
            'name' => 'Rizky Ramadhan',
            'nim' => '17022019',
            'email' => 'rizky.arsitektur@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Teknik Sipil & Perencanaan',
            'study_program' => 'Arsitektur',
            'semester' => 5,
            'batch' => '2022',
            'phone' => '0812-4455-6677',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=200',
        ]);

        $clara = User::create([
            'name' => 'Clara Wijaya',
            'nim' => '16021008',
            'email' => 'dr.clara@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'active',
            'faculty' => 'Kedokteran',
            'study_program' => 'Pendidikan Dokter',
            'semester' => 7,
            'batch' => '2021',
            'phone' => '0813-8899-0011',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200',
        ]);

        $kevin = User::create([
            'name' => 'Kevin Sanjaya',
            'nim' => '15022088',
            'email' => 'kevin.sanjaya99@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'suspended',
            'suspend_reason' => 'Indikasi komersialisasi berulang: menjual materi perkuliahan gratis & markup tinggi.',
            'faculty' => 'Ilmu Hukum',
            'study_program' => 'Ilmu Hukum',
            'semester' => 5,
            'batch' => '2022',
            'phone' => '0852-9988-7766',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=200',
        ]);

        // 2. Seed Items (Koleksi Realistis untuk Presentasi Demo Kampus)

        // Item 1: Casio Calculator (Siti Rahma) - Harga Pas
        $itemCasio = Item::create([
            'user_id' => $siti->id,
            'title' => 'Kalkulator Scientific Casio fx-991EX ClassWiz',
            'category' => 'Elektronik & Gadget Belajar',
            'condition' => 'Bekas Layak Pakai',
            'condition_note' => 'Baterai baru ganti, solar cell normal 100%',
            'description' => 'Dijual santai karena sudah lulus mata kuliah kalkulus dan fisika dasar semester ini. Tombol masih sangat empuk dan responsif, solar cell berfungsi dengan baik. Ada sedikit goresan halus pemakaian wajar di cover belakang.',
            'mode' => 'harga_pas',
            'price' => 45000,
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma). Jam senggang setelah jam 13.00.',
            'meetup_location' => 'Kantin Gedung B Farmasi / Perpus Pusat',
            'time_handover' => 'Senin - Kamis (13.00 - 17.00 WIB)',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemCasio->id,
            'image_path' => 'images/items/kalkulator.svg',
            'is_primary' => true,
        ]);
        ItemImage::create([
            'item_id' => $itemCasio->id,
            'image_path' => 'images/items/kalkulator-2.svg',
            'is_primary' => false,
        ]);

        // Item 2: Headset Gaming Rexus (Dimas Saputra) - Barter
        $itemHeadset = Item::create([
            'user_id' => $dimas->id,
            'title' => 'Headset Gaming Rexus Audio',
            'category' => 'Elektronik & Gadget Belajar',
            'condition' => 'Seperti Baru',
            'description' => 'Suara jernih surround, mic bening buat Google Meet / Discord kuliah kelompok. Mau barter sama mouse wireless atau keyboard mini.',
            'mode' => 'barter',
            'barter_request' => 'Mouse Wireless Logitech / Keyboard Mini',
            'contact_info' => 'WhatsApp: 0813-1122-3344 (Dimas). Sering standby di asrama.',
            'meetup_location' => 'Asrama Mahasiswa Blok B / Gazebo Teknik',
            'time_handover' => 'Setiap sore setelah jam 16.00',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemHeadset->id,
            'image_path' => 'images/items/headset.svg',
            'is_primary' => true,
        ]);

        // Item 3: Buku Pemrograman Web (Andi Pratama) - Gratis (Locked, Klaim Approved)
        $itemBuku = Item::create([
            'user_id' => $andi->id,
            'title' => 'Buku Pemrograman Web & Framework',
            'category' => 'Buku & Catatan',
            'condition' => 'Seperti Baru',
            'description' => 'Buku pegangan semester 4 teknik informatika. Masih sangat rapi tanpa coretan, lengkap bonus file latihan coding.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0812-3456-7890 (Andi). Bisa ketemuan di Fasilkom.',
            'meetup_location' => 'Gedung Fasilkom lantai 2',
            'time_handover' => 'Hari kerja jam kuliah',
            'status' => 'locked',
        ]);
        ItemImage::create([
            'item_id' => $itemBuku->id,
            'image_path' => 'images/items/buku.svg',
            'is_primary' => true,
        ]);

        // Item 4: Jaket Almamater (Nabila Putri) - Barter (Locked, Klaim Approved)
        $itemJaket = Item::create([
            'user_id' => $nabila->id,
            'title' => 'Jaket Almamater Ukuran L',
            'category' => 'Fashion & Jaket',
            'condition' => 'Seperti Baru',
            'description' => 'Ukuran L terlalu longgar untuk saya, ingin barter ke almamater size M yang masih bersih dan utuh kancingnya.',
            'mode' => 'barter',
            'barter_request' => 'Jaket Almamater Size M',
            'contact_info' => 'WhatsApp: 0821-1122-3344 (Nabila)',
            'meetup_location' => 'Lobi Fakultas Hukum',
            'time_handover' => 'Senin - Rabu jam istirahat',
            'status' => 'locked',
        ]);
        ItemImage::create([
            'item_id' => $itemJaket->id,
            'image_path' => 'images/items/jaket.svg',
            'is_primary' => true,
        ]);

        // Item 5: Set Praktikum Biologi Dasar (Siti Rahma) - Gratis
        $itemBiologi = Item::create([
            'user_id' => $siti->id,
            'title' => 'Set Alat Praktikum Biologi Dasar',
            'category' => 'Alat Praktikum',
            'condition' => 'Ada Kekurangan',
            'condition_note' => 'Pinset 1 patah, pipet tetes kaca pecah 1',
            'description' => 'Pinset anatomi, kaca preparat, dan pisau bedah. Pipet tetes kaca pecah 1 biji, sisanya masih sangat layak pakai untuk maba semester 1.',
            'mode' => 'gratis',
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma)',
            'meetup_location' => 'Lab Biologi Kampus / Kantin Farmasi',
            'time_handover' => 'Jumat jam 10.00 - 15.00 WIB',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemBiologi->id,
            'image_path' => 'images/items/biologi.svg',
            'is_primary' => true,
        ]);

        // Item 6: Tas Kuliah Laptop 14 inch (Dimas Saputra) - Harga Pas
        $itemTas = Item::create([
            'user_id' => $dimas->id,
            'title' => 'Tas Ransel Kuliah Bodypack 14 inch',
            'category' => 'Perlengkapan Kuliah',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Slot laptop muat 15 inch dengan busa tebal aman benturan. Resleting utama lancar, ada sedikit pudar pemakaian di bagian bawah tapi kain tidak ada yang sobek.',
            'mode' => 'harga_pas',
            'price' => 35000,
            'contact_info' => 'WhatsApp: 0813-1122-3344 (Dimas)',
            'meetup_location' => 'Perpustakaan Pusat Kampus',
            'time_handover' => 'Fleksibel sore hari',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemTas->id,
            'image_path' => 'images/items/tas.svg',
            'is_primary' => true,
        ]);

        // Item 7: Modul Pelanggaran (Kevin Sanjaya - Target Moderasi Admin FR-10)
        $itemModul = Item::create([
            'user_id' => $kevin->id,
            'title' => 'Modul Cetak & Soal Ujian Lama Hukum Bisnis',
            'category' => 'Buku & Catatan',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Kumpulan bank soal dan modul ujian tahun lalu. Dijual paket komplit materi berbayar.',
            'mode' => 'harga_pas',
            'price' => 120000,
            'contact_info' => 'WhatsApp: 0852-9988-7766',
            'meetup_location' => 'Kantin Luar Kampus',
            'time_handover' => 'Malam hari',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemModul->id,
            'image_path' => 'images/items/modul.svg',
            'is_primary' => true,
        ]);

        // Item 8: Jas Praktikum Laboratorium Putih (Siti Rahma) - Gratis
        $itemJasLab = Item::create([
            'user_id' => $siti->id,
            'title' => 'Jas Praktikum Laboratorium Kimia Size M',
            'category' => 'Alat Praktikum',
            'condition' => 'Seperti Baru',
            'condition_note' => 'Bahan tebal katun oxford, kancing lengkap',
            'description' => 'Jas laboratorium lengan panjang dengan karet elastis di pergelangan tangan, aman untuk praktikum kimia dan farmasi. Sudah dicuci bersih dan disetrika rapi, dihibahkan cuma-cuma untuk adik tingkat yang membutuhkan.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma)',
            'meetup_location' => 'Lobi Fakultas Farmasi Lantai 1',
            'time_handover' => 'Senin - Rabu (12.00 - 16.00 WIB)',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemJasLab->id,
            'image_path' => 'images/items/jas-lab.svg',
            'is_primary' => true,
        ]);

        // Item 9: Buku Kalkulus Purcell Edisi 9 (Andi Pratama) - Harga Pas (Siap Demo Approval Multi-Klaim)
        $itemKalkulus = Item::create([
            'user_id' => $andi->id,
            'title' => 'Buku Kalkulus Purcell Edisi 9 Jilid 1',
            'category' => 'Buku & Catatan',
            'condition' => 'Bekas Layak Pakai',
            'condition_note' => 'Halaman lengkap 450 hal, ada stabilo di bab turunan',
            'description' => 'Buku legendaris pegangan TPB seluruh jurusan teknik dan MIPA. Penjelasan teorema sangat jelas, lengkap dengan pembahasan soal-soal ganjil. Dilepas harga terjangkau ramah kantong mahasiswa.',
            'mode' => 'harga_pas',
            'price' => 50000,
            'contact_info' => 'WhatsApp: 0812-3456-7890 (Andi)',
            'meetup_location' => 'Gazebo Fasilkom / Kantin Boulevard Kampus',
            'time_handover' => 'Selasa & Kamis jam istirahat siang',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemKalkulus->id,
            'image_path' => 'images/items/kalkulus.svg',
            'is_primary' => true,
        ]);

        // Item 10: Penggaris T-Square & Tabung Gambar (Rizky Ramadhan) - Barter
        $itemArsitektur = Item::create([
            'user_id' => $rizky->id,
            'title' => 'Penggaris T-Square 80cm & Tabung Gambar Drafting Tube',
            'category' => 'Perlengkapan Kuliah',
            'condition' => 'Seperti Baru',
            'description' => 'Set drafting arsitektur original. Tabung gambar kedap air muat kertas A1/A0 gulung, T-square akrilik lurus presisi tanpa cacat. Mau barter sama Drawing Pen set lengkap (0.1 - 0.8) atau buku sketsa A3.',
            'mode' => 'barter',
            'barter_request' => 'Drawing Pen Snowman/Sakura Pigma Set Lengkap atau Sketsa A3',
            'contact_info' => 'WhatsApp: 0812-4455-6677 (Rizky Arsi)',
            'meetup_location' => 'Studio Gambar Arsitektur Gedung C',
            'time_handover' => 'Senin - Jumat jam kuliah',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemArsitektur->id,
            'image_path' => 'images/items/t-square.svg',
            'is_primary' => true,
        ]);

        // Item 11: Kemeja Putih Formal Sidang Skripsi (Dimas Saputra) - Gratis
        $itemKemeja = Item::create([
            'user_id' => $dimas->id,
            'title' => 'Kemeja Putih Formal Sidang Skripsi Size L',
            'category' => 'Fashion & Jaket',
            'condition' => 'Seperti Baru',
            'condition_note' => 'Hanya 1x pakai saat sidang yudisium skripsi',
            'description' => 'Kemeja putih katun polos lengan panjang include dasi hitam formal. Sudah dicuci laundry wangi. Dihibahkan gratis untuk rekan mahasiswa yang mau sidang skripsi atau magang kerja.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0813-1122-3344 (Dimas)',
            'meetup_location' => 'Lobi Utama Rektorat Kampus',
            'time_handover' => 'Sore hari sekitar jam 16.30 WIB',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemKemeja->id,
            'image_path' => 'images/items/kemeja-sidang.svg',
            'is_primary' => true,
        ]);

        // Item 12: Stetoskop Medis (Clara Wijaya) - Harga Pas
        $itemStetoskop = Item::create([
            'user_id' => $clara->id,
            'title' => 'Stetoskop Medis Litmann Classic II SE',
            'category' => 'Alat Praktikum',
            'condition' => 'Bekas Layak Pakai',
            'condition_note' => 'Akustik tajam, earpiece empuk bebas robek',
            'description' => 'Stetoskop andalan selama kepaniteraan klinik dasar kedokteran. Diafragma sensitif, bell berfungsi prima. Cocok untuk mahasiswa kedokteran, keperawatan, atau kebidanan tingkat awal.',
            'mode' => 'harga_pas',
            'price' => 150000,
            'contact_info' => 'WhatsApp: 0813-8899-0011 (Clara FK)',
            'meetup_location' => 'Depan RS Pendidikan Kampus / Kantin FK',
            'time_handover' => 'Rabu - Jumat jam 15.00 - 18.00 WIB',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemStetoskop->id,
            'image_path' => 'images/items/stetoskop.svg',
            'is_primary' => true,
        ]);

        // Item 13: Buku Kimia Organik Fessenden (Siti Rahma) - Gratis
        $itemOrganik = Item::create([
            'user_id' => $siti->id,
            'title' => 'Buku Kimia Organik Fessenden & Fessenden Jilid 1',
            'category' => 'Buku & Catatan',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Buku pegangan wajib mahasiswa farmasi dan teknik kimia. Membahas tuntas mekanisme reaksi senyawa organik, hidrokarbon, dan spektroskopi. Masih sangat jelas dibaca.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma)',
            'meetup_location' => 'Perpustakaan Farmasi Kampus',
            'time_handover' => 'Kamis & Jumat siang',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemOrganik->id,
            'image_path' => 'images/items/organik.svg',
            'is_primary' => true,
        ]);

        // 3. Seed Claims (Skenario Realistis untuk Transaksi Live & UAT)

        // Casio: 1 klaim pending oleh Andi
        Claim::create([
            'item_id' => $itemCasio->id,
            'claimant_id' => $andi->id,
            'contact_info' => '0812-3456-7890 (@andipratama)',
            'message' => 'Halo Kak Siti, saya Andi butuh banget buat persiapan responsi minggu depan. Bisa ambil nanti sore di kampus.',
            'status' => 'pending',
        ]);

        // Headset: 1 tawaran barter pending oleh Andi
        Claim::create([
            'item_id' => $itemHeadset->id,
            'claimant_id' => $andi->id,
            'contact_info' => '0812-3456-7890',
            'message' => 'Mau tawarkan barter mouse wireless saya.',
            'offered_item_desc' => 'Mouse Wireless Logitech M331 Silent Click hitam kondisi seperti baru lengkap box.',
            'status' => 'pending',
        ]);

        // Buku Pemrograman: 1 klaim APPROVED oleh Nabila (Menunjukkan Locked State & Kontak Terbuka)
        $claimBukuApproved = Claim::create([
            'item_id' => $itemBuku->id,
            'claimant_id' => $nabila->id,
            'contact_info' => '0821-1122-3344 (@nabila.putri)',
            'message' => 'Halo Kak Andi, butuh banget buku ini buat referensi matkul web semester ini. Makasih banyak!',
            'status' => 'approved',
        ]);

        // Jaket Almamater: 1 klaim APPROVED oleh Dimas (Menunjukkan Barter Approved)
        $claimJaketApproved = Claim::create([
            'item_id' => $itemJaket->id,
            'claimant_id' => $dimas->id,
            'contact_info' => '0813-1122-3344 (@dimas.saputra)',
            'message' => 'Halo Kak Nabila, kebetulan saya punya almamater size M yang agak sempit. Mau barter.',
            'offered_item_desc' => 'Almamater size M masih mulus warna hijau tua kampus tanpa noda.',
            'status' => 'approved',
        ]);

        // Buku Kalkulus: 2 KLAIM PENDING (Skenario Emas untuk Live Demo Persetujuan & Auto-Lock)
        // Pemilik buku adalah Andi Pratama. Saat login sebagai Andi -> Buka "Pengajuan Masuk" -> Klik Setujui!
        Claim::create([
            'item_id' => $itemKalkulus->id,
            'claimant_id' => $clara->id,
            'contact_info' => '0813-8899-0011 (@dr.clara)',
            'message' => 'Halo Kak Andi, saya butuh buku kalkulus ini untuk mata kuliah biostatistika kedokteran. Siap bayar harga pas Rp 50.000.',
            'status' => 'pending',
        ]);
        Claim::create([
            'item_id' => $itemKalkulus->id,
            'claimant_id' => $rizky->id,
            'contact_info' => '0812-4455-6677 (@rizky.arsitektur)',
            'message' => 'Halo Kak Andi, saya Rizky Arsitektur butuh untuk hitungan mekanika struktur. Mau ambil langsung di Fasilkom.',
            'status' => 'pending',
        ]);

        // 4. Seed Ratings (Reputasi Kebaikan Mahasiswa)
        Rating::create([
            'claim_id' => $claimBukuApproved->id,
            'rater_id' => $nabila->id,
            'rated_user_id' => $andi->id,
            'score' => 5,
        ]);
        Rating::create([
            'claim_id' => $claimJaketApproved->id,
            'rater_id' => $dimas->id,
            'rated_user_id' => $nabila->id,
            'score' => 5,
        ]);
        Rating::create([
            'claim_id' => $claimBukuApproved->id,
            'rater_id' => $dimas->id,
            'rated_user_id' => $siti->id,
            'score' => 5,
        ]);

        // 5. Seed Reports (Untuk Demo Moderasi Admin FR-10 & FR-11)
        Report::create([
            'reporter_id' => $andi->id,
            'item_id' => $itemModul->id,
            'reason' => 'Melanggar Hak Cipta Komersial',
            'details' => 'Menjual fotokopian bank soal & modul dosen dengan markup harga tinggi komersial di lingkungan kampus.',
            'status' => 'open',
        ]);
    }
}
