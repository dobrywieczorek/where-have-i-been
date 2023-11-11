<?php

namespace Tests\Unit;

use App\Models\MapPin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapPinTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_map_pin()
    {
        // Arrange
        $data = [
            'pin_name' => 'Test Pin',
            'description' => 'Test description',
            'favourite' => false,
            'latitude' => 123.456789,
            'longitude' => -45.678901,
            'user_id' => "4325",
            'category' => "hotel"
        ];

        // Act
        $mapPin = MapPin::create($data);

        // Assert
        $this->assertInstanceOf(MapPin::class, $mapPin);
        $this->assertEquals($data['pin_name'], $mapPin->pin_name);
        $this->assertEquals($data['description'], $mapPin->description);
        $this->assertEquals($data['favourite'], $mapPin->favourite);
        $this->assertEquals($data['latitude'], $mapPin->latitude);
        $this->assertEquals($data['longitude'], $mapPin->longitude);
        $this->assertEquals($data['user_id'], $mapPin->user_id);
        $this->assertEquals($data['category'], $mapPin->category);
    }

    // Add more tests as needed
}
