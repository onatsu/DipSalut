<?php

namespace App\Domain\User;

interface IUserDataProvider
{
    public function getFromToken(string $token): ?UserData;
}