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

    public function test_RegisterRoute_MissingParameter_400Response(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(400);
    }

    public function test_LoginRoute_CorrectLogin_200Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->post('/api/login', [
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);
    
        $response->assertStatus(200);
    }

    public function test_LoginRoute_IncorrectUser_401Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->post('/api/login', [
            'email' => 'john12@example.com',
            'password' => 'Password123',
        ]);
    
        $response->assertStatus(401);
    }

}
