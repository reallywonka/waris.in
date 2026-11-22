<?php

namespace Tests\Feature;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndToEndScenarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_campus_lifecycle_from_listing_to_lock_and_admin_moderation(): void
    {
        // 1. Registrasi Mahasiswa Pemilik (Budi)
        $owner = User::factory()->create([
            'name' => 'Budi Setiawan',
            'email' => 'budi.setiawan@kampus.ac.id',
            'nim' => '13521001',
            'faculty' => 'Fasilkom',
            'study_program' => 'Teknik Informatika',
            'semester' => 5,
            'phone' => '0812-1111-2222',
            'role' => 'mahasiswa',
            'status' => 'active',
        ]);

        // 2. Mahasiswa Pemilik Mengunggah Barang (Mode Gratis)
        $item = Item::create([
            'user_id' => $owner->id,
            'title' => 'Buku Algoritma & Struktur Data Pemrograman',
            'category' => 'Buku & Catatan',
            'condition' => 'Seperti Baru',
            'description' => 'Buku pegangan wajib semester 3. Lengkap tanpa coretan.',
            'mode' => 'gratis',
            'price' => null,
            'contact_info' => 'WhatsApp: 0812-1111-2222 (Budi)',
            'meetup_location' => 'Lobi Utama Gedung Fasilkom',
            'time_handover' => 'Senin - Rabu jam istirahat siang',
            'status' => 'available',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'title' => 'Buku Algoritma & Struktur Data Pemrograman',
            'status' => 'available',
            'price' => null,
        ]);

        // 3. Registrasi Mahasiswa Peminat 1 (Citra) & Mahasiswa Peminat 2 (Dodi)
        $claimant1 = User::factory()->create([
            'name' => 'Citra Lestari',
            'email' => 'citra.lestari@kampus.ac.id',
            'nim' => '13522002',
            'faculty' => 'Fasilkom',
            'study_program' => 'Sistem Informasi',
            'semester' => 3,
            'phone' => '0813-3333-4444',
            'role' => 'mahasiswa',
            'status' => 'active',
        ]);

        $claimant2 = User::factory()->create([
            'name' => 'Dodi Pratama',
            'email' => 'dodi.pratama@kampus.ac.id',
            'nim' => '13522003',
            'faculty' => 'Fasilkom',
            'study_program' => 'Teknik Informatika',
            'semester' => 3,
            'phone' => '0814-5555-6666',
            'role' => 'mahasiswa',
            'status' => 'active',
        ]);

        // 4. Mahasiswa Peminat Mengajukan Permohonan Klaim
        $claimResponse1 = $this->actingAs($claimant1)->post(route('claims.store', $item), [
            'contact_info' => '0813-3333-4444',
            'message' => 'Halo Kak Budi, saya butuh buku ini untuk matkul struktur data.',
        ]);
        $claimResponse1->assertRedirect();
        $claimResponse1->assertSessionHas('success');

        $claimResponse2 = $this->actingAs($claimant2)->post(route('claims.store', $item), [
            'contact_info' => '0814-5555-6666',
            'message' => 'Halo Kak, saya juga ingin mengajukan buku ini jika masih ada.',
        ]);
        $claimResponse2->assertRedirect();
        $claimResponse2->assertSessionHas('success');

        $this->assertEquals(2, $item->claims()->count());

        $claim1 = $item->claims()->where('claimant_id', $claimant1->id)->first();
        $claim2 = $item->claims()->where('claimant_id', $claimant2->id)->first();

        $this->assertEquals('pending', $claim1->status);
        $this->assertEquals('pending', $claim2->status);

        // 5. Pemilik Menyetujui Klaim Citra (Approval Atomic & Auto-Lock FR-08)
        $approveResponse = $this->actingAs($owner)->post(route('claims.approve', $claim1));
        $approveResponse->assertRedirect();
        $approveResponse->assertSessionHas('success');

        // Verifikasi Integritas Data
        $item->refresh();
        $claim1->refresh();
        $claim2->refresh();

        $this->assertEquals('locked', $item->status, 'Barang harus berstatus locked setelah klaim disetujui');
        $this->assertEquals('approved', $claim1->status, 'Klaim terpilih harus berstatus approved');
        $this->assertEquals('rejected', $claim2->status, 'Klaim peminat lain harus otomatis ditolak (rejected)');

        // 6. Verifikasi Pembukaan Kontak (FR-09)
        // Citra melihat informasi kontak Budi di halaman Pengajuan Saya
        $citraClaimsView = $this->actingAs($claimant1)->get(route('claims.my'));
        $citraClaimsView->assertOk();
        $citraClaimsView->assertSee('WhatsApp: 0812-1111-2222');

        // Budi melihat informasi kontak Citra di halaman Pengajuan Masuk
        $budiIncomingView = $this->actingAs($owner)->get(route('claims.incoming'));
        $budiIncomingView->assertOk();
        $budiIncomingView->assertSee('0813-3333-4444');

        // 7. Pengawasan & Moderasi Admin Kampus (FR-10 & FR-11)
        $admin = User::factory()->create([
            'name' => 'Admin Kampus Pengawas',
            'email' => 'admin.pengawas@waris.in',
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Admin Mengakses Portal Moderasi
        $adminDashboard = $this->actingAs($admin)->get(route('admin.dashboard'));
        $adminDashboard->assertOk();
        $adminDashboard->assertSee('Portal Moderasi Kampus');

        // Admin Melakukan Hapus Paksa Listing yang Melanggar (FR-10)
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.items.destroy', $item));
        $deleteResponse->assertRedirect();
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('items', ['id' => $item->id]);

        // Admin Men-suspend Akun Mahasiswa yang Melanggar (FR-11)
        $suspendResponse = $this->actingAs($admin)->post(route('admin.users.suspend', $claimant2), [
            'suspend_reason' => 'Menyalahgunakan fitur transaksi untuk spamming.',
        ]);
        $suspendResponse->assertRedirect();
        $suspendResponse->assertSessionHas('success');

        $claimant2->refresh();
        $this->assertTrue($claimant2->isSuspended());
        $this->assertEquals('Menyalahgunakan fitur transaksi untuk spamming.', $claimant2->suspend_reason);

        // Akun yang di-suspend langsung ditolak dan dialihkan ke login
        $blockedResponse = $this->actingAs($claimant2)->get(route('dashboard'));
        $blockedResponse->assertRedirect(route('login'));
        $blockedResponse->assertSessionHas('error');
    }
}
