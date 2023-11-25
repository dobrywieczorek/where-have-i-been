<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_GetUserStats_CorrectData_200Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->withHeaders([])->get('/api/getUserStats?user_id=1',[]);

        $response->assertStatus(200);
    }

    public function test_GetUserStats_CorrectData_ReturnCorrectNumberOfFriends(): void
    {
        $register1 = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $register2 = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john12@example.com',
            'password' => 'Password123',
        ]);

        $token = $register1['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/addfriend',[
            'friend_id' => '2',
        ]);

        $response = $this->withHeaders([])->get('/api/getUserStats?user_id=1',[]);

        $responseData = $response->decodeResponseJson();

        $this->assertEquals($responseData['numberOfFriends'], 1);
    }

    public function test_GetUserStats_IdUserDoesntExist_400Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->withHeaders([])->get('/api/getUserStats?user_id=2',[]);

        $response->assertStatus(400);
    }

    public function test_GetUserStats_IdEqualsZero_400Response(): void
    {
        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->withHeaders([])->get('/api/getUserStats?user_id=0',[]);

        $response->assertStatus(400);
    }

}
