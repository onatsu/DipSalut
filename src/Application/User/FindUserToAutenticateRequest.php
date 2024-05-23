<?php

namespace App\Application\User;

class FindUserToAutenticateRequest
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}