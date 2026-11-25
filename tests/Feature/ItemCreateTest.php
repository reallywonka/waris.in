<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('items.create'));

        $response->assertStatus(200);
        $this->assertStringContainsString('x-data="itemCreateForm()"', $response->getContent());
    }

    public function test_authenticated_user_can_store_item_with_category_and_cod_details(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'Meja Belajar Lipat Kayu',
            'category' => 'Perlengkapan Kos',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Meja lipat masih kokoh, cocok untuk di kamar kos.',
            'mode' => 'harga_pas',
            'price' => 50000,
            'contact_info' => 'WhatsApp: 081234567890',
            'meetup_location' => 'Gazebo Fasilkom',
            'time_handover' => 'Senin-Jumat sore',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'title' => 'Meja Belajar Lipat Kayu',
            'category' => 'Perlengkapan Kos',
            'contact_info' => 'WhatsApp: 081234567890',
            'meetup_location' => 'Gazebo Fasilkom',
            'time_handover' => 'Senin-Jumat sore',
        ]);
    }
}
