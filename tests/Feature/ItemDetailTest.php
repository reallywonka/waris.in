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
}
