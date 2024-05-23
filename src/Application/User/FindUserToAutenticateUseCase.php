<?php

namespace App\Application\User;

use App\Domain\User\Exceptions\UserDataNotFoundException;
use App\Domain\User\IUserDataProvider;
use App\Domain\User\IUserRepository;
use App\Entity\User;

class FindUserToAutenticateUseCase
{

    public function __construct(private IUserDataProvider $userDataProvider,private IUserRepository $userRepository)
    {
    }

    public function execute(FindUserToAutenticateRequest $request): User
    {
        $userData = $this->userDataProvider->getFromToken($request->getToken());
        if($userData === null){
            throw new UserDataNotFoundException();
        }

        $user = $this->userRepository->getFromUserData($userData);
        if($user === null){
            $user = $this->userRepository->createFromUserData($userData);
        }

        return $user;
    }
}