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


}
