<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MapControllerTest extends TestCase
{
    /**
     * Test retrieving map pins.
     *
     * @return void
     */
    public function testGetMapPins()
    {
        $response = $this->get('/get-map-pins'); // Adjust the route according to your application

        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'name',
                'description',
                'when',
                'userid',
                'istrip',
            ],
        ]);
    }
}
