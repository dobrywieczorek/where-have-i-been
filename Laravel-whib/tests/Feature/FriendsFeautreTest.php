<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FriendsFeautreTest extends TestCase
{
    use RefreshDatabase;

    public function test_AddFriendRoute_CorrectFriend_200Response(): void
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

        $response->assertStatus(200);
    }

    public function test_AddFriendRoute_IncorrectFriend_401Response(): void
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
            'friend_id' => '0',
        ]);

        $response->assertStatus(401);
    }

}
