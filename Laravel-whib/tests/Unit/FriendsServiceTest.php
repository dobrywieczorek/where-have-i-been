<?php

namespace Tests\Unit;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Interfaces\IFriendsRepository;
use App\Http\Interfaces\IFriendsService;
use App\Http\Services\FriendsService;

class FriendsServiceTest extends TestCase
{
    public function test_AddFriend_CorrectFriends_ReturnsSuccessTrue() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(false);
        $friendsRepository->shouldReceive('AddFriend')->andReturn();

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->AddFriend(1, 2);
        $this->assertTrue($result['success']);
    }

    public function test_AddFriend_AlreadyFriends_ReturnsSuccessFalse() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(true);

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->AddFriend(1, 2);
        $this->assertFalse($result['success']);
    }

    public function test_AddFriend_SameIds_ReturnsSuccessFalse() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(false);
        $friendsRepository->shouldReceive('AddFriend')->andReturn();

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->AddFriend(2, 2);
        $this->assertFalse($result['success']);
    }

    public function test_AddFriend_IdEqualsZero_ReturnsSuccessFalse() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(false);
        $friendsRepository->shouldReceive('AddFriend')->andReturn();

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->AddFriend(0, 2);
        $this->assertFalse($result['success']);
    }

    public function test_DeleteFriend_CorrectFriends_ReturnsSuccessTrue() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(true);
        $friendsRepository->shouldReceive('DeleteFriend')->andReturn();

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->DeleteFriend(1, 2);
        $this->assertTrue($result['success']);
    }

    public function test_DeleteFriend_SameIds_ReturnsSuccessFalse() : void
    {
        $friendsRepository = Mockery::mock(IFriendsRepository::class);

        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $friendsRepository->shouldReceive('AlreadyFriends')->andReturn(true);
        $friendsRepository->shouldReceive('DeleteFriend')->andReturn();

        $friendsService = new FriendsService($friendsRepository);

        $result = $friendsService->DeleteFriend(2, 2);
        $this->assertFalse($result['success']);
    }

}
