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
            'batch' => '2023',
            'phone' => '0821-1122-3344',
            'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=200',
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
            'batch' => '2022',
            'phone' => '0852-9988-7766',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=200',
        ]);

        // 2. Seed Items
        // Item 1: Casio Calculator (Siti Rahma) - Harga Pas
        $itemCasio = Item::create([
            'user_id' => $siti->id,
            'title' => 'Kalkulator Scientific Casio fx-991EX ClassWiz',
            'category' => 'Elektronik & Gadget Belajar',
            'condition' => 'Bekas Layak Pakai',
            'condition_note' => 'Baterai baru ganti, fungsi 100% normal',
            'description' => 'Dijual santai karena sudah selesai mata kuliah kalkulus dan fisika dasar semester ini. Tombol masih sangat empuk dan responsif, solar cell berfungsi dengan baik. Ada sedikit goresan halus pemakaian wajar di cover belakang.',
            'mode' => 'harga_pas',
            'price' => 45000,
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma). Jam senggang setelah jam 13.00.',
            'meetup_location' => 'Kantin Gedung B Farmasi / Perpus Pusat',
            'time_handover' => 'Senin - Kamis (13.00 - 17.00 WIB)',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemCasio->id,
            'image_path' => 'https://images.unsplash.com/photo-1594980596870-8aa52a78d8cd?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);
        ItemImage::create([
            'item_id' => $itemCasio->id,
            'image_path' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?auto=format&fit=crop&q=80&w=800',
            'is_primary' => false,
        ]);

        // Item 2: Headset Gaming Rexus (Dimas Saputra) - Barter
        $itemHeadset = Item::create([
            'user_id' => $dimas->id,
            'title' => 'Headset Gaming Rexus Audio',
            'category' => 'Elektronik & Gadget Belajar',
            'condition' => 'Seperti Baru',
            'description' => 'Suara jernih surround, mic bening buat Google Meet / Discord kuliah. Mau barter sama mouse wireless atau keyboard mini.',
            'mode' => 'barter',
            'barter_request' => 'Mouse Wireless Logitech / Keyboard Mini',
            'contact_info' => 'WhatsApp: 0813-1122-3344 (Dimas). Sering standby di asrama.',
            'meetup_location' => 'Asrama Mahasiswa Blok B / Gazebo Teknik',
            'time_handover' => 'Setiap sore setelah jam 16.00',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemHeadset->id,
            'image_path' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // Item 3: Buku Pemrograman Web (Andi Pratama) - Gratis (Locked)
        $itemBuku = Item::create([
            'user_id' => $andi->id,
            'title' => 'Buku Pemrograman Web & Framework',
            'category' => 'Buku & Catatan',
            'condition' => 'Seperti Baru',
            'description' => 'Buku pegangan semester 4 teknik informatika. Masih sangat rapi tanpa coretan, lengkap bonus file latihan.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0812-3456-7890 (Andi). Bisa ketemuan di Fasilkom.',
            'meetup_location' => 'Gedung Fasilkom lantai 2',
            'time_handover' => 'Hari kerja jam kuliah',
            'status' => 'locked',
        ]);
        ItemImage::create([
            'item_id' => $itemBuku->id,
            'image_path' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3777a?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // Item 4: Jaket Almamater (Nabila Putri) - Barter (Locked)
        $itemJaket = Item::create([
            'user_id' => $nabila->id,
            'title' => 'Jaket Almamater Ukuran L',
            'category' => 'Fashion & Jaket',
            'condition' => 'Seperti Baru',
            'description' => 'Ukuran L terlalu longgar, ingin barter ke almamater size M yang masih layak dan bersih.',
            'mode' => 'barter',
            'barter_request' => 'Jaket Almamater Size M',
            'contact_info' => 'WhatsApp: 0821-1122-3344 (Nabila)',
            'meetup_location' => 'Lobi Fakultas Hukum',
            'time_handover' => 'Senin - Rabu',
            'status' => 'locked',
        ]);
        ItemImage::create([
            'item_id' => $itemJaket->id,
            'image_path' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // Item 5: Set Praktikum Biologi Dasar (Siti Rahma) - Gratis
        $itemBiologi = Item::create([
            'user_id' => $siti->id,
            'title' => 'Set Alat Praktikum Biologi Dasar',
            'category' => 'Alat Praktikum',
            'condition' => 'Ada Kekurangan',
            'condition_note' => 'Pinset 1 patah, alat lain lengkap',
            'description' => 'Pinset, kaca preparat, dan pisau bedah. Pipet tetes kaca pecah 1 biji, sisanya masih sangat layak pakai untuk maba semester 1.',
            'mode' => 'gratis',
            'contact_info' => 'WhatsApp: 0812-9876-5432 (Siti Rahma)',
            'meetup_location' => 'Lab Biologi Kampus / Kantin Farmasi',
            'time_handover' => 'Jumat jam 10.00 - 15.00 WIB',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemBiologi->id,
            'image_path' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // Item 6: Tas Kuliah Laptop 14 inch (Dimas Saputra) - Harga Pas
        $itemTas = Item::create([
            'user_id' => $dimas->id,
            'title' => 'Tas Ransel Kuliah Bodypack 14 inch',
            'category' => 'Perlengkapan Kuliah',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Slot laptop muat 15 inch dengan busa tebal aman. Resleting utama lancar, ada sedikit pudar pemakaian di bagian bawah tapi kain tidak ada yang sobek.',
            'mode' => 'harga_pas',
            'price' => 35000,
            'contact_info' => 'WhatsApp: 0813-1122-3344 (Dimas)',
            'meetup_location' => 'Perpustakaan Pusat',
            'time_handover' => 'Fleksibel sore hari',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemTas->id,
            'image_path' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // Item 7: Modul Cetak & Soal Ujian Lama (Kevin Sanjaya - Dilaporkan)
        $itemModul = Item::create([
            'user_id' => $kevin->id,
            'title' => 'Modul Cetak & Soal Ujian Lama Hukum Bisnis',
            'category' => 'Buku & Catatan',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Kumpulan bank soal dan modul ujian tahun lalu. Dijual paket komplit.',
            'mode' => 'harga_pas',
            'price' => 120000,
            'contact_info' => 'WhatsApp: 0852-9988-7766',
            'meetup_location' => 'Kantin Luar Kampus',
            'time_handover' => 'Malam hari',
            'status' => 'available',
        ]);
        ItemImage::create([
            'item_id' => $itemModul->id,
            'image_path' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800',
            'is_primary' => true,
        ]);

        // 3. Seed Claims
        // Claim on Casio (Pending by Andi)
        Claim::create([
            'item_id' => $itemCasio->id,
            'claimant_id' => $andi->id,
            'contact_info' => '0812-3456-7890 (@andipratama)',
            'message' => 'Halo Kak Siti, saya Andi butuh banget buat persiapan responsi minggu depan. Bisa ambil nanti sore di kampus.',
            'status' => 'pending',
        ]);

        // Claim on Headset (Pending by Andi with Barter offer)
        Claim::create([
            'item_id' => $itemHeadset->id,
            'claimant_id' => $andi->id,
            'contact_info' => '0812-3456-7890',
            'message' => 'Mau tawarkan barter mouse wireless saya.',
            'offered_item_desc' => 'Mouse Wireless Logitech M331 Silent Click hitam kondisi seperti baru lengkap box.',
            'status' => 'pending',
        ]);

        // Claim on Buku Pemrograman (Approved by Andi to Nabila)
        $claimBukuApproved = Claim::create([
            'item_id' => $itemBuku->id,
            'claimant_id' => $nabila->id,
            'contact_info' => '0821-1122-3344 (@nabila.putri)',
            'message' => 'Halo Kak Andi, butuh banget buku ini buat referensi matkul web semester ini. Makasih banyak!',
            'status' => 'approved',
        ]);

        // 4. Seed Ratings
        // Nabila rates Andi 5 stars for the Web Book
        Rating::create([
            'claim_id' => $claimBukuApproved->id,
            'rater_id' => $nabila->id,
            'rated_user_id' => $andi->id,
            'score' => 5,
        ]);

        // Siti has some high ratings from previous exchanges
        Rating::create([
            'claim_id' => $claimBukuApproved->id,
            'rater_id' => $dimas->id,
            'rated_user_id' => $siti->id,
            'score' => 5,
        ]);
        Rating::create([
            'claim_id' => $claimBukuApproved->id,
            'rater_id' => $andi->id,
            'rated_user_id' => $siti->id,
            'score' => 5,
        ]);

        // 5. Seed Reports (for Admin moderasi demo)
        Report::create([
            'reporter_id' => $andi->id,
            'item_id' => $itemModul->id,
            'reason' => 'Melanggar Hak Cipta Komersial',
            'details' => 'Menjual fotokopian bank soal & modul dosen dengan markup harga tinggi komersial.',
            'status' => 'open',
        ]);
    }
}
