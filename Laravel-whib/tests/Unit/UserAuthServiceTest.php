<?php

namespace Tests\Unit;

use App\Models\User;
use App\Http\Interfaces\IUserAuthRepository;
use App\Http\Services\UserAuthService;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;

class UserAuthServiceTest extends TestCase
{
    public function test_AddUser_CorrectUser_ReturnsSuccessTrue() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUser')->andReturn(['name' => 'John', 'email' => 'john@example.com']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'Password1', 
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->AddUser($request);
        $this->assertTrue($result['success']);
    }




}

