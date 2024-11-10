<?php

namespace App\Entities;

class User
{


    /**
     * keeping attributes public for simple serialisation with json_encode
     * 
     * @param int $userId
     * @param string $name
     * @param string $email
     */
    public function __construct(private int $userId, private string $name, private string $email)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            "userId" => $this->userId,
            "name" => $this->name,
            "email" => $this->email,
        ];
    }

}