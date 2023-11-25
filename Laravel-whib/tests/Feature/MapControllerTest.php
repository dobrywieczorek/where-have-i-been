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
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        // Create map pins associated with the authenticated user
        $mapPins = MapPin::factory()->count(3)->create(['user_id' => $user->id]);

        // Make a GET request to the show endpoint
        $response = $this->get('/api/map-pins');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the map pins are in the response
        foreach ($mapPins as $mapPin) {
            $response->assertSee($mapPin->pin_name);
        }

        // Assert that the response does not contain specific JSON fragments
        $response->assertDontSee([
            'error' => 'Unauthorized',
            // Add any other expected JSON fragments you want to check
        ]);
    }

    public function testStore()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        // Define the map pin data (without 'description')
        $mapPinData = [
            'pin_name' => $this->faker->word,
            'favourite' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'category' => $this->faker->word,
            'description' => null, // 'description' is optional in this test
            // Add any other fields as needed
        ];

        // Make a POST request to the store endpoint with map pin data
        $response = $this->post('/api/map-pins', $mapPinData);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the map pin is stored in the database
        $this->assertDatabaseHas('map_pins', [
            'user_id' => $user->id,
            'pin_name' => $mapPinData['pin_name'],
            'favourite' => $mapPinData['favourite'],
            'latitude' => $mapPinData['latitude'],
            'longitude' => $mapPinData['longitude'],
            'category' => $mapPinData['category'],
            'description' => $mapPinData['description'],
            // Add any other fields as needed
        ]);

        // Assert that the response does not contain specific JSON fragments
        $response->assertJsonMissing([
            'error' => 'Unauthorized',
            // Add any other expected JSON fragments you want to check
        ]);
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
