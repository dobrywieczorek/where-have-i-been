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

    public function test_RegisterRoute_InvalidName_400Response(): void
    {
        $response = $this->post('/api/register', [
            'name' => '#John',
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

    public function test_LoginRoute_MissingParameter_400Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->post('/api/login', [
            'password' => 'Password123',
        ]);
    
        $response->assertStatus(400);
    }

    public function test_WhoAmIRoute_CorrectToken_200Response(): void
    {
        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/whoami');
    
        $response->assertStatus(200);
    }

    public function test_WhoAmIRoute_IncorrectToken_500Response(): void
    {
        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . '12345678',
        ])->post('/api/whoami');
    
        $response->assertStatus(500);
    }

    public function test_EditUserRoute_CorrectUser_200Response(): void
    {

        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/edituser',[
            'name' => 'John Doe',
            'password' => 'Password123',
            'description' => 'blabla'
        ]);

        $response->assertStatus(200);
    }

    public function test_EditUserRoute_MissingPassword_200Response(): void
    {

        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/edituser',[
            'name' => 'John Doe',
            'description' => 'blabla'
        ]);

        $response->assertStatus(200);
    }

    public function test_EditUserRoute_OnlyName_200Response(): void
    {

        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/edituser',[
            'name' => 'John Doe1',
        ]);

        $response->assertStatus(200);
    }

    public function test_EditUserRoute_InvalidPassword_401Response(): void
    {
        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/edituser',[
            'name' => 'John Doe',
            'password' => 'Password',
            'description' => 'blabla'
        ]);

        $response->assertStatus(401);
    }

    public function test_LogoutUser_CorrectData_200Response(): void
    {
        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout',[]);

        $response->assertStatus(200);
    }

    public function test_LogoutUser_IncorrectData_500Response(): void
    {
        $registerResponse = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $token = $registerResponse['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . 123456,
        ])->post('/api/logout',[]);

        $response->assertStatus(500);
    }
}
