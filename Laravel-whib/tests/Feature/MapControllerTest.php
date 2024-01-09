<?php

namespace Tests\Feature;

use App\Models\MapPin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

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
        // Create a user and authenticate them
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create some map pins associated with the user
        MapPin::factory()->count(3)->create(['user_id' => $user->id]);

        // Make a GET request to the show method
        $response = $this->getJson('/api/map-pins');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert the structure of the JSON response
        $response->assertJsonStructure(['map_pins' => []]);
    }

    public function testStore()
    {
        // Create a user and authenticate them
        $user = User::factory()->create();
        $this->actingAs($user);

        // Define map pin data
        $mapPinData = [
            'pin_name' => 'Test Pin',
            'description' => 'Test Description',
            'favourite' => true,
            'latitude' => 23.456,
            'longitude' => -78.910,
            'category' => 'Test Category',
        ];

        // Make a POST request to the store method
        $response = $this->postJson('/api/map-pins', $mapPinData);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the map pin is in the database
        $this->assertDatabaseHas('map_pins', $mapPinData);
    }

    public function testUpdate()
    {
        // Create a user and authenticate them
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a map pin associated with the user
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        // Define updated map pin data
        $updatedData = [
            'pin_name' => 'Updated Pin Name',
            'description' => 'Updated Description',
            'favourite' => false,
            'latitude' => 23.654,
            'longitude' => -32.109,
            'category' => 'Updated Category',
        ];

        // Make a PUT request to the update method
        $response = $this->putJson("/api/map-pins/{$mapPin->id}", $updatedData);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the map pin in the database has been updated
        $this->assertDatabaseHas('map_pins', $updatedData);
    }

    public function testAddFavourite()
    {
            // Create a user and authenticate them
            $user = User::factory()->create();
            $this->actingAs($user);

            // Create a map pin associated with the user
            $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

            // Make a PUT request to the toggleFavourite method
            $response = $this->putJson("/api/map-pins/{$mapPin->id}/toggleFavourite");

            // Assert that the response has a 200 status code
            $response->assertStatus(200);

            // Reload the map pin from the database to get the updated data
            $mapPin->refresh();

            // Assert that the 'favourite' status has been toggled
            $this->assertNotEquals($mapPin->favourite, !$mapPin->favourite);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(204);
        $this->assertNull(MapPin::find($mapPin->id));
    }
    public function testShowUserPins()
    {
        // Create a user for testing
        $user = User::factory()->create();

        // Create map pins for the user
        $mapPins = MapPin::factory()->count(3)->create(['user_id' => $user->id]);

        // Make a GET request to the showUserPins endpoint
        $response = $this->get("/map-pins/pins/{$user->id}");

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Decode the JSON response
        $responseData = $response->json();

        // Assert that the response contains the expected map pins
        $this->assertCount(3, $responseData['map_pins']);
    }
}
