<?php

namespace Tests\Feature;

use App\Models\MapPin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MapControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations and seeders
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /** @test */
    public function it_returns_user_map_pins()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/map-pins');

        $response->assertStatus(200);
        $response->assertJson(['map_pins' => [$mapPin->toArray()]]);
    }

    /** @test */
    public function it_returns_specific_map_pin()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(200);
        $response->assertJson(['map_pin' => $mapPin->toArray()]);
    }

    /** @test */
    public function it_stores_new_map_pin()
    {
        $user = User::factory()->create();
        $mapPinData = MapPin::factory()->make()->toArray();

        $response = $this->actingAs($user)->post('/api/map-pins', $mapPinData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('map_pins', $mapPinData);
    }

    /** @test */
    public function it_updates_existing_map_pin()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);
        $updatedData = ['pin_name' => 'Updated Pin Name'];

        $response = $this->actingAs($user)->put("/api/map-pins/{$mapPin->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('map_pins', array_merge(['id' => $mapPin->id], $updatedData));
    }

    /** @test */
    public function it_deletes_existing_map_pin()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('map_pins', ['id' => $mapPin->id]);
    }
}
