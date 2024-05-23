<?php

namespace App\Tests\Application\User;

use App\Application\User\FindUserToAutenticateRequest;
use App\Domain\User\Exceptions\UserDataNotFoundException;
use App\Domain\User\IUserRepository;
use App\Domain\User\IUserDataProvider;
use App\Domain\User\UserData;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Application\User\FindUserToAutenticateUseCase;

class FindUserToAutenticateUseCaseTest extends TestCase {
    private $userData;
    private $user;
    private $token;
    private $userDataProviderMock;
    private $userRepositoryMock;
    private $sut;

    public function setUp():void
    {
        $this->userData = new UserData('name', 'surname', 'email', 'nif');
        $this->user = new User();
        $this->token = '1/kJ1qAO2qTmEiz9fMzVl0gEHJdzV35Lz9uJIPF5Cu';
        $this->userDataProviderMock = $this->createMock(IUserDataProvider::class);
        $this->userRepositoryMock = $this->createMock(IUserRepository::class);
        $this->sut = new FindUserToAutenticateUseCase($this->userDataProviderMock, $this->userRepositoryMock);
    }

    /** @test */
    public function given_a_user_data__should_return_the_user () {
        // Arrange
        $this->userDataProviderMock->expects($this->once())->method('getFromToken')->with($this->token)->willReturn($this->userData);
        $this->userRepositoryMock->expects($this->once())->method('getFromUserData')->with($this->userData)->willReturn($this->user);

        // Act
        $response = $this->sut->execute(new FindUserToAutenticateRequest($this->token));

        //Assert
        $this->assertEquals($this->user, $response);
    }

    /** @test */
    public function given_a_non_existing_user__should_create_the_user () {
        // Arrange
        $this->userDataProviderMock->expects($this->once())->method('getFromToken')->with($this->token)->willReturn($this->userData);
        $this->userRepositoryMock->expects($this->once())->method('getFromUserData')->with($this->userData)->willReturn(null);
        $this->userRepositoryMock->expects($this->once())->method('createFromUserData')->with($this->userData)->willReturn($this->user);

        //Act
        $response = $this->sut->execute(new FindUserToAutenticateRequest($this->token));

        //Assert
        $this->assertEquals($this->user,$response);
    }

    /** @test */
    public function given_a_non_existing_user_data__should_throw_exception () {
        // Arrange & Assert
        $this->userDataProviderMock->expects($this->once())->method('getFromToken')->with($this->token)->willReturn(null);
        $this->expectException(UserDataNotFoundException::class);

        //Act
        $this->sut->execute(new FindUserToAutenticateRequest($this->token));
    }
}