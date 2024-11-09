<?php

namespace App\Entities;

class User {


    /**
     * keeping attributes public for simple serialisation with json_encode
     * 
     * @param int $userId
     * @param string $name
     * @param string $email
     */
    public function __construct(public int $userId, public string $name, public string $email) {}
}