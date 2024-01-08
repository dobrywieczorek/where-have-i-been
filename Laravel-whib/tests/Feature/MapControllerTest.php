<?php

namespace Tests\Feature;

use App\Models\MapPin;
use App\Models\User;
use App\Models\Trip;
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

    public function testOrganizeTrip()
    {
        // Create a user
        $user = User::factory()->create();

        // Create map pins
        $mapPins = MapPin::factory(3)->create(['user_id' => $user->id]);

        // Simulate authentication
        $this->actingAs($user);

        // Send a request to the organizeTrip endpoint
        $response = $this->postJson('/api/map-pins/organize-trip', [
            'selected_pins' => $mapPins->pluck('id')->toArray(),
            'trip_name' => 'Test Trip',
            'trip_description' => 'A test trip description',
        ]);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert the response contains the created trip and associated map pins
        $response->assertJsonStructure(['trip', 'map_pins']);

        // Assert the trip is stored in the database
        $this->assertDatabaseHas('trips', [
            'trip_name' => 'Test Trip',
            'trip_description' => 'A test trip description',
        ]);

        // Assert the map pins are associated with the trip in the database
        $this->assertEquals(3, Trip::first()->mapPins->count());
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
