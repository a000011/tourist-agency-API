<?php

namespace App\Entities;

class LoginCredentialsEntity
{
    public function __construct(
        private string $login,
        private string $password
    ) {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
