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

    private array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
    ];

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

        $result = $userAuthService->AddUser($request, $this->rules);
        $this->assertTrue($result['success']);
    }

    public function test_AddUser_InvalidPassword_ReturnsSuccessFalse() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUser')->andReturn(['name' => 'John', 'email' => 'john@example.com']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password1', 
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->AddUser($request, $this->rules);
        $this->assertFalse($result['success']);
    }

    public function test_AddUser_NullData_ReturnsSuccessFalse() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUser')->andReturn(['name' => 'John', 'email' => 'john@example.com']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            null
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->AddUser($request, $this->rules);
        $this->assertFalse($result['success']);
    }

    public function test_AddUser_EmptyNameString_ReturnsSuccessFalse() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUser')->andReturn(['name' => 'John', 'email' => 'john@example.com']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            'name' => '',
            'email' => 'john@example.com',
            'password' => 'password1', 
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->AddUser($request, $this->rules);
        $this->assertFalse($result['success']);
    }

    public function test_AddUser_EmptyEmailString_ReturnsSuccessFalse() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUser')->andReturn(['name' => 'John', 'email' => 'john@example.com']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            'name' => 'John',
            'email' => '',
            'password' => 'password1', 
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->AddUser($request, $this->rules);
        $this->assertFalse($result['success']);
    }

    public function test_AddUserToken_ReceivesToken_ReturnsToken() : void
    {
        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('AddUserToken')->andReturn(['authToken' => '5|1Ab2c3d4']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $userData = [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'Password1', 
        ];

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->CreateUserToken($request);
        $this->assertEquals('5|1Ab2c3d4', $result['authToken']);
    }

    public function test_LoginUser_CorrectUser_ReturnsSuccessTrue() : void
    {
        $userData = [
            'email' => 'john@example.com',
            'password' => 'Password1', 
        ];

        $userAuthRepository = Mockery::mock(IUserAuthRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthRepository->shouldReceive('TryAuthUser')->andReturn(true);
        $userAuthRepository->shouldReceive('GetUserWithEmail')->andReturn(['email' => '123@22.com']);
        $userAuthRepository->shouldReceive('AddUserToken')->andReturn(['token' => '123adwab']);

        $userAuthService = new UserAuthService($userAuthRepository);

        $request = Request::create('/dummy', 'POST', $userData);

        $result = $userAuthService->LoginUser($request);
        $this->assertTrue($result['success']);
    }

    public function test_LoginUser_InvalidUser_ReturnsSuccessFalse() : void
    {
        $userData = [
            'email' => 'john@example.com',
            'password' => 'Password1', 
        ];



}

