<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_item_detail_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Budi Santoso',
            'faculty' => 'Fasilkom',
            'batch' => '2022',
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'title' => 'Buku Kalkulus Purcel Edisi 9',
            'category' => 'Buku & Modul',
            'condition' => 'Bekas Layak Pakai',
            'condition_note' => 'Ada coretan stabilo di bab 3',
            'description' => 'Buku wajib kalkulus 1 & 2 semester kemarin.',
            'mode' => 'harga_pas',
            'price' => 45000,
            'contact_info' => '08123456789',
            'meetup_location' => 'Perpustakaan Pusat Lt 1',
            'time_handover' => 'Senin - Kamis jam 16:00',
            'status' => 'available',
        ]);

        $response = $this->get(route('items.show', $item));

        $response->assertStatus(200);
        $response->assertSee('Buku Kalkulus Purcel Edisi 9');
        $response->assertSee('Rp 45.000');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Perpustakaan Pusat Lt 1');
        $response->assertSee('Ada coretan stabilo di bab 3');
    }

    public function test_owner_sees_management_options_on_item_detail(): void
    {
        $owner = User::factory()->create(['name' => 'Owner Mahasiswa']);
        $item = Item::create([
            'user_id' => $owner->id,
            'title' => 'Kalkulator Casio fx-991EX',
            'category' => 'Elektronik',
            'condition' => 'Seperti Baru',
            'description' => 'Masih mulus baru dipakai 1 semester.',
            'mode' => 'gratis',
            'contact_info' => '0812999999',
            'status' => 'available',
        ]);

        $response = $this->actingAs($owner)->get(route('items.show', $item));

        $response->assertStatus(200);
        $response->assertSee('Barang Anda Sendiri');
        $response->assertSee('Kelola Barang Saya');
    }

    public function test_non_owner_sees_claim_modal_and_cta_button(): void
    {
        $owner = User::factory()->create(['name' => 'Pemilik']);
        $buyer = User::factory()->create(['name' => 'Pembeli']);
        $item = Item::create([
            'user_id' => $owner->id,
            'title' => 'Jas Lab Farmasi Ukuran L',
            'category' => 'Alat Praktikum',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Dipakai saat praktikum biologi farmasi.',
            'mode' => 'harga_pas',
            'price' => 35000,
            'contact_info' => '08123456789',
            'status' => 'available',
        ]);

        $response = $this->actingAs($buyer)->get(route('items.show', $item));

        $response->assertStatus(200);
        $response->assertSee('Ajukan Pembelian Harga Pas');
        $response->assertSee('Formulir Permohonan Beli Harga Pas');
        $response->assertSee(route('claims.store', $item));
        $response->assertDontSee('style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"', false);
    }

    public function test_authenticated_user_sees_navigation_and_dashboard_my_items(): void
    {
        $user = User::factory()->create([
            'name' => 'Arsha Student',
            'study_program' => 'Farmasi',
            'semester' => 5,
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'title' => 'Mikroskop Mini Mahasiswa',
            'category' => 'Alat Praktikum',
            'condition' => 'Seperti Baru',
            'description' => 'Barang praktikum pribadi.',
            'mode' => 'harga_pas',
            'price' => 50000,
            'contact_info' => '0811223344',
            'status' => 'available',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Barang Saya');
        $response->assertSee('Pengajuan Masuk');
        $response->assertSee('Pengajuan Saya');
        $response->assertSee('Barang yang Sedang Kamu Tawarkan / Jual');
        $response->assertSee('Mikroskop Mini Mahasiswa');
    }
}
