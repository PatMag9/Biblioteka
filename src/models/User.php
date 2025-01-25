<?php

class User
{
    private $email;
    private $password;
    private $isAdmin;

    public function __construct(string $email, string $password, bool $isAdmin)
    {
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
}