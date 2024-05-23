<?php

namespace App\Domain\User;

class UserData
{

    public function __construct(private string $name,private string $surname,private string $email,private string $nif)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNif(): string
    {
        return $this->nif;
    }


}