<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModerationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $student;
    private Item $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Kampus',
            'email' => 'admin@waris.in',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->student = User::factory()->create([
            'name' => 'Mahasiswa Biasa',
            'email' => 'mhs@waris.in',
            'role' => 'mahasiswa',
            'status' => 'active',
        ]);

        $this->item = Item::create([
            'user_id' => $this->student->id,
            'title' => 'Buku Catatan Pelanggaran Hak Cipta',
            'category' => 'Buku & Modul',
            'condition' => 'Bekas Layak Pakai',
            'description' => 'Materi kuliah ilegal berbayar.',
            'mode' => 'harga_pas',
            'price' => 50000,
            'contact_info' => '08123456789',
            'status' => 'available',
        ]);
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_normal_student_cannot_access_admin_portal(): void
    {
        $response = $this->actingAs($this->student)->get(route('admin.dashboard'));
        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_portal(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Portal Moderasi Kampus');
        $response->assertSee('Moderasi Listing Barang (FR-10)');
        $response->assertSee('Kelola Mahasiswa & Suspend (FR-11)', false);
    }

    public function test_admin_can_force_delete_an_offending_item(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.items.destroy', $this->item));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('items', [
            'id' => $this->item->id,
        ]);
    }

    public function test_admin_can_suspend_a_student_account_with_reason(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.suspend', $this->student), [
            'suspend_reason' => 'Melakukan komersialisasi materi kuliah gratis.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->student->refresh();
        $this->assertTrue($this->student->isSuspended());
        $this->assertEquals('Melakukan komersialisasi materi kuliah gratis.', $this->student->suspend_reason);
    }

    public function test_suspended_user_is_logged_out_and_redirected_to_login(): void
    {
        $this->student->update([
            'status' => 'suspended',
            'suspend_reason' => 'Pelanggaran ketentuan COD kampus.',
        ]);

        // Pengguna yang disuspend mencoba mengakses dashboard mahasiswa
        $response = $this->actingAs($this->student)->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_admin_can_activate_a_suspended_student(): void
    {
        $this->student->update([
            'status' => 'suspended',
            'suspend_reason' => 'Perlu klarifikasi.',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.users.activate', $this->student));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->student->refresh();
        $this->assertFalse($this->student->isSuspended());
        $this->assertNull($this->student->suspend_reason);
    }

    public function test_admin_cannot_suspend_another_admin(): void
    {
        $anotherAdmin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.users.suspend', $anotherAdmin), [
            'suspend_reason' => 'Mencoba suspend admin lain.',
        ]);

        $response->assertSessionHas('error');
        $this->assertFalse($anotherAdmin->fresh()->isSuspended());
    }
}
