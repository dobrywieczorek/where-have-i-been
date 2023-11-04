<?php


namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_RegisterRoute_CorrectUser_200Response(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(200);
    }

    public function test_RegisterRoute_NoName_400Response(): void
    {
        $response = $this->post('/api/register', [
            'name' => '',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(400);
    }

}
