<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class MapControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test retrieving map pins.
     *
     * @return void
     */
    public function testGetMapPins()
    {
        Storage::put('map_pins.json', json_encode([
            [
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'name' => 'San Francisco',
                'description' => 'A beautiful city by the bay.',
                'when' => '12.02.2023',
                'userid' => '01',
                'istring' => true,
            ],
        ]));
        $response = $this->get('/get-map-pins');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'latitude',
                        'longitude',
                        'name',
                        'description',
                        'when',
                        'userid',
                        'istring',
                    ],
                ],
            ]);
    }
}
