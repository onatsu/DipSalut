<?php

namespace App\Domain\User;

use App\Entity\User;

interface IUserRepository
{

    public function getFromUserData(UserData $userData): ?User;
    public function createFromUserData(UserData $userData): User;
}