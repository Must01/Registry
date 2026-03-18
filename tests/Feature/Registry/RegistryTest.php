<?php

namespace Tests\Feature\Registry;

use App\Models\Registry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_registry(): void
    {
        $response = $this->get('/registry/create');

        $response->assertRedirect("/login");
    }

    public function test_guest_cannot_store_registry(): void
    {
        $response = $this->post('/registry', ['reference_no' => 'REG-001']);

        $response->assertRedirect("/login");
    }

    public function test_user_can_create_registry(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/registry", [
            'reference_no' => 'REG-001',
            'date' => '2024-01-15',
            'sender' => 'ABC Corporation',
            'recipient' => 'Our Company',
            'subject' => 'Quarterly report request',
            'remarks' => 'Follow up needed by end of month',
            'attachments' => json_encode([])
        ]);

        $this->assertDatabaseHas("registries", [
            'reference_no' => 'REG-001',
        ]);

        $response->assertRedirect(route("registry.index"));
    }

    public function test_user_can_read_registry(): void
    {
        $user = User::factory()->create();
        $registry = Registry::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/registry/' . $registry->id);

        $response->assertStatus(200);
        $response->assertSee($registry->reference_no);
    }

    public function test_user_can_update_registry(): void
    {
        $user = User::factory()->create();

        $registry = Registry::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put('/registry/' . $registry->id, [
            'reference_no' => "UPDATED-0001",
            'date' => '12-04-2023',
            'sender' => "someone"
        ]);

        $this->assertDatabaseHas('registries', [
            'reference_no' => "UPDATED-0001",
        ]);

        $response->assertRedirect(route("registry.index"));
    }

    public function test_user_can_delete_registry(): void
    {
        $user = User::factory()->create();

        $registry = Registry::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas("registries", [
            'reference_no' => $registry->reference_no
        ]);

        $response = $this->actingAs($user)->delete('/registry/' . $registry->id);

        $this->assertDatabaseMissing("registries", [
            'reference_no' => $registry->reference_no
        ]);

        $response->assertRedirect(route('registry.index'));
    }
}
