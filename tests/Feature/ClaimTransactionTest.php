<?php

namespace Tests\Feature;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimTransactionTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $claimant1;
    private User $claimant2;
    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'name' => 'Fajar Owner',
            'phone' => '081234567890',
            'faculty' => 'Fasilkom',
        ]);

        $this->claimant1 = User::factory()->create([
            'name' => 'Budi Claimant',
            'phone' => '089876543210',
            'faculty' => 'Farmasi',
        ]);

        $this->claimant2 = User::factory()->create([
            'name' => 'Citra Claimant',
            'phone' => '085555555555',
            'faculty' => 'Teknik Elektro',
        ]);

        $this->item = Item::create([
            'user_id' => $this->owner->id,
            'title' => 'Kalkulator Casio FX-991EX',
            'category' => 'Elektronik & Gadget Belajar',
            'condition' => 'Seperti Baru',
            'description' => 'Dipakai satu semester, kondisi sangat mulus.',
            'mode' => 'harga_pas',
            'price' => 150000,
            'contact_info' => '081234567890',
            'meetup_location' => 'Perpustakaan Pusat Kampus',
            'time_handover' => 'Senin - Jumat 15.00 WIB',
            'status' => 'available',
        ]);
    }

    public function test_student_can_submit_claim_for_available_item(): void
    {
        $response = $this->actingAs($this->claimant1)->post(route('claims.store', $this->item), [
            'contact_info' => '089876543210',
            'message' => 'Halo Kak, saya butuh kalkulator ini untuk ujian kalkulus minggu depan.',
        ]);

        $response->assertRedirect(route('items.show', $this->item));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('claims', [
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'status' => 'pending',
            'contact_info' => '089876543210',
        ]);
    }

    public function test_owner_cannot_claim_their_own_item(): void
    {
        $response = $this->actingAs($this->owner)->post(route('claims.store', $this->item), [
            'contact_info' => '081234567890',
            'message' => 'Mencoba klaim barang sendiri.',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('claims', [
            'item_id' => $this->item->id,
            'claimant_id' => $this->owner->id,
        ]);
    }

    public function test_student_cannot_submit_duplicate_claims_for_same_item(): void
    {
        Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'contact_info' => '089876543210',
            'message' => 'Klaim pertama.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->claimant1)->post(route('claims.store', $this->item), [
            'contact_info' => '089876543210',
            'message' => 'Klaim kedua yang seharusnya ditolak.',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, Claim::where('item_id', $this->item->id)->where('claimant_id', $this->claimant1->id)->count());
    }

    public function test_owner_can_view_incoming_claims(): void
    {
        Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'contact_info' => '089876543210',
            'message' => 'Saya ingin membeli kalkulator ini.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->owner)->get(route('claims.incoming'));

        $response->assertOk();
        $response->assertSee('Dashboard Pengajuan Masuk');
        $response->assertSee('Budi Claimant');
        $response->assertSee('Kalkulator Casio FX-991EX');
    }

    public function test_atomic_approval_locks_item_approves_selected_claim_and_rejects_other_pending_claims(): void
    {
        $claim1 = Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'contact_info' => '089876543210',
            'message' => 'Saya yang pertama berminat.',
            'status' => 'pending',
        ]);

        $claim2 = Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant2->id,
            'contact_info' => '085555555555',
            'message' => 'Saya peminat kedua.',
            'status' => 'pending',
        ]);

        // Pemilik menyetujui pengajuan milik claimant1
        $response = $this->actingAs($this->owner)->post(route('claims.approve', $claim1));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // 1. Status barang harus berubah menjadi locked
        $this->assertEquals('locked', $this->item->fresh()->status);

        // 2. Status claim1 harus menjadi approved
        $this->assertEquals('approved', $claim1->fresh()->status);

        // 3. Status claim2 harus otomatis menjadi rejected
        $this->assertEquals('rejected', $claim2->fresh()->status);
    }

    public function test_owner_can_reject_a_claim(): void
    {
        $claim = Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'contact_info' => '089876543210',
            'message' => 'Tawaran yang tidak sesuai.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->owner)->post(route('claims.reject', $claim));

        $response->assertRedirect();
        $response->assertSessionHas('info');

        $this->assertEquals('rejected', $claim->fresh()->status);
        $this->assertEquals('available', $this->item->fresh()->status);
    }

    public function test_student_can_view_my_claims_dashboard_with_unlocked_contact_after_approval(): void
    {
        $claim = Claim::create([
            'item_id' => $this->item->id,
            'claimant_id' => $this->claimant1->id,
            'contact_info' => '089876543210',
            'message' => 'Mohon persetujuannya kak.',
            'status' => 'approved',
        ]);
        $this->item->update(['status' => 'locked']);

        $response = $this->actingAs($this->claimant1)->get(route('claims.my'));

        $response->assertOk();
        $response->assertSee('Dashboard Pengajuan Saya');
        $response->assertSee('Pengajuan Anda Disetujui!');
        $response->assertSee('081234567890'); // Kontak pemilik terbuka
        $response->assertSee('Perpustakaan Pusat Kampus'); // Titik COD terbuka
    }

    public function test_owner_can_manage_my_items(): void
    {
        $response = $this->actingAs($this->owner)->get(route('items.my'));

        $response->assertOk();
        $response->assertSee('Manajemen Barang Saya');
        $response->assertSee('Kalkulator Casio FX-991EX');
    }
}
