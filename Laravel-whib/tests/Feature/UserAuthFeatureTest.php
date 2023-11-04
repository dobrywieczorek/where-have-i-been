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

}
