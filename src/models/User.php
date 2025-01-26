<?php

class User
{
    private $idUser;
    private $email;
    private $password;
    private $isAdmin;

    public function __construct(int $idUser, string $email, string $password, bool $isAdmin)
    {
        $this->idUser = $idUser;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
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