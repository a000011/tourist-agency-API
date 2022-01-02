<?php

namespace App\Entities;

class RegistrationCredentialsEntity
{
    public function __construct(
        private string $login,
        private string $password,
        private string $firstname,
        private string $lastname,
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
}
