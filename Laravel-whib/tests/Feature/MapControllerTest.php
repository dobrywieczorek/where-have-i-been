<?php

namespace Tests\Feature;

use App\Models\MapPin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MapControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex()
    {
        $user = User::factory()->create();
        MapPin::factory(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/map-pins');

        $response->assertStatus(200)
            ->assertJsonStructure(['map_pins']);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['map_pin']);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $mapPinData = MapPin::factory()->make(['user_id' => $user->id])->toArray();

        // Ensure required fields are present
        $response = $this->actingAs($user)->post('/api/map-pins', [
            'pin_name' => $mapPinData['pin_name'],
            'description' => $mapPinData['description'],
            'favourite' => $mapPinData['favourite'],
            'latitude' => $mapPinData['latitude'],
            'longitude' => $mapPinData['longitude'],
            'user_id' => $mapPinData['user_id'],
            'category' => $mapPinData['category'],
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['map_pin']);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);
        $updatedData = [
            'pin_name' => 'Updated Pin Name',
            'description' => 'Updated Description',
            'favourite' => true,
            'latitude' => 45.678,
            'longitude' => -78.910,
            'user_id' => $user->id,
            'category' => 'Updated Category',
        ];

        // Ensure required fields are present
        $response = $this->actingAs($user)->put("/api/map-pins/{$mapPin->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonStructure(['map_pin']);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(204);
        $this->assertNull(MapPin::find($mapPin->id));
    }
}
