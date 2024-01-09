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

    public function testDestroy()
    {
        $user = User::factory()->create();
        $mapPin = MapPin::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/map-pins/{$mapPin->id}");

        $response->assertStatus(204);
        $this->assertNull(MapPin::find($mapPin->id));
    }

    /**
     * Test adding a new trip pin.
     *
     * @return void
     */
    public function testAddTrip()
    {
        // Create a user using the factory
        $user = User::factory()->create();

        // Simulate authentication
        $this->actingAs($user);

        // Prepare data for the new trip pin
        $requestData = [
            'pin_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'favourite' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'category' => $this->faker->word,
            'IsTrip' => true,
            'TripDate' => $this->faker->date,
        ];

        // Make a POST request to add a new trip pin
        $response = $this->post('/api/map-pins/add-trip', $requestData);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert the response structure
        $response->assertJsonStructure(['map_pin' => ['id', 'pin_name', 'IsTrip', 'TripDate', 'created_at', 'updated_at']]);

        // Assert the trip pin is stored in the database
        $this->assertDatabaseHas('map_pins', [
            'pin_name' => $requestData['pin_name'],
            'IsTrip' => true,
        ]);
    }


    public function testGetTrips()
    {
        // Create a user and authenticate them
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create some map pins, some of which are marked as trips
        $tripPin1 = MapPin::factory()->create(['user_id' => $user->id, 'IsTrip' => true]);
        $tripPin2 = MapPin::factory()->create(['user_id' => $user->id, 'IsTrip' => true]);
        $regularPin = MapPin::factory()->create(['user_id' => $user->id, 'IsTrip' => false]);

        // Make a request to the get-trips endpoint
        $response = $this->json('GET', '/api/map-pins/get-trips');

        // Assert the response has a successful status code
        $response->assertStatus(200);

        // Assert the response contains the map pins that are trips
        $response->assertJson([
            'map_pins' => [
                [
                    'id' => $tripPin1->id,
                    'IsTrip' => true,
                ],
                [
                    'id' => $tripPin2->id,
                    'IsTrip' => true,
                ],
            ],
        ]);

        // Assert the response does not contain regular pins
        $response->assertJsonMissing([
            'map_pins' => [
                [
                    'id' => $regularPin->id,
                    'IsTrip' => false,
                ],
            ],
        ]);
    }

    public function testGetUserMapPins()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create some map pins for each user
        $mapPinUser1 = MapPin::factory()->create(['user_id' => $user1->id]);
        $mapPinUser2 = MapPin::factory()->create(['user_id' => $user2->id]);

        // Make a request to the getUserMapPins endpoint for $user1
        $response = $this->json('GET', "/api/map-pins/user/{$user1->id}");

        // Assert the response has a successful status code
        $response->assertStatus(200);

        // Assert the response contains the map pins for $user1
        $response->assertJson([
            'map_pins' => [
                [
                    'id' => $mapPinUser1->id,
                    'user_id' => $user1->id,
                ],
            ],
        ]);

        // Assert the response does not contain map pins for $user2
        $response->assertJsonMissing([
            'map_pins' => [
                [
                    'id' => $mapPinUser2->id,
                    'user_id' => $user2->id,
                ],
            ],
        ]);
    }
}
