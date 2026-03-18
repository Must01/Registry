<?php

namespace Tests\Feature\Registry;

use App\Models\Registry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests For Guest User
     */
    public function test_guest_cannot_view_registries(): void
    {
        $response = $this->get("/registry");

        $response->assertRedirect('/login');
    }

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

    public function test_guest_cannot_delete_registry(): void
    {
        $user = User::factory()->create();
        $registry = Registry::factory()->create(['user_id' => $user->id]);

        $response = $this->delete("/registry/" . $registry->id);

        $response->assertRedirect('/login');
    }

    /**
     * Tests For AUTH user Registry CRUD
     */
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

    /**
     * Tests For Unauthorized Registry Actions
     */
    public function test_user_cannot_view_other_users_registry(): void
    {
        $userA = User::factory()->create(["name" => "userA"]);
        $userB = User::factory()->create(["name" => "userB"]);

        $registry = Registry::factory()->create(["user_id" => $userA->id]);

        $response = $this->actingAs($userB)->get("/registry/" . $registry->id);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_other_users_registry(): void
    {
        $userA = User::factory()->create(["name" => "userA"]);
        $userB = User::factory()->create(["name" => "userB"]);

        $registry = Registry::factory()->create(["user_id" => $userA->id]);

        $response = $this->actingAs($userB)->put('/registry/' . $registry->id, [
            "reference_no" => "UPDATED_0000"
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_other_users_registry(): void
    {
        $userA = User::factory()->create(["name" => "userA"]);
        $userB = User::factory()->create(["name" => "userB"]);

        $registry = Registry::factory()->create(["user_id" => $userA->id]);

        $response = $this->actingAs($userB)->delete("/registry/" . $registry->id);

        $response->assertStatus(403);
    }

    /**
     * Validation tests
     */
    public function test_user_cannot_create_empty_registry(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/registry', [
            'reference_no' => '',
            'date' => '',
            'sender' => ''
        ]);

        $this->assertDatabaseMissing("registries", ['reference_no' => '']);
        $response->assertSessionHasErrors('reference_no');
    }
}
