<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Capsule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CapsuleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_accessing_capsules_requires_authentication()
    {
        $response = $this->getJson('/api/capsule/all');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_retrieve_all_their_capsules()
    {
        $user = User::factory()->create();
        $capsules = Capsule::factory()->count(3)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/capsule/all');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_authenticated_user_can_create_a_capsule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/capsule/store', [
            'message' => 'Future message',
            'openeingTime' => now()->addDay()->toDateTimeString(),
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.message', 'Future message');

        $this->assertDatabaseHas('capsules', [
            'message' => 'Future message',
        ]);
    }

    public function test_capsule_creation_requires_future_opening_time()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/capsule/store', [
            'message' => 'Test Message',
            'openeingTime' => now()->subDay()->format("Y-m-d H:i:s"), // Past time
        ]);

        $response->assertStatus(422)
        ->assertJsonStructure(['error']);
    }

    public function test_user_can_update_their_capsule()
    {
        $user = User::factory()->create();
        $capsule = Capsule::factory()->create([
            'created_by' => $user->id,
            'message' => 'Old Message',
            'openeing_time' => now()->addDays(10)->format("Y-m-d H:i:s"),
        ]);

        $response = $this->actingAs($user, 'sanctum')->patchJson("/api/capsule/update/{$capsule->id}", [
            'message' => 'Updated Message',
            'id' => $capsule->id,
            'openeingTime' => now()->addDays(20)->toDateTimeString(),
        ]);

        $response->assertStatus(200)
             ->assertJsonMissing(['error']);
        
        $this->assertDatabaseHas('capsules', [
            'id' => $capsule->id,
            'message' => 'Updated Message',
        ]);
    }

    public function test_user_can_delete_their_capsule()
    {
        $user = User::factory()->create();
        $capsule = Capsule::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/capsule/{$capsule->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('capsules', ['id' => $capsule->id]);
    }
}
