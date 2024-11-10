<?php

namespace App\Repositories\User;

use App\Entities\User;


/**
 * A placeholder implementation fo a third party user provider, 
 * to demonstrate that the design supports swappable user provider
 */
class DBUserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): array
    {
        // Placeholder implementation
        return [
            new User(1, "Database User 1", "dbuser1@example.com"),
            new User(2, "Database User 2", "dbuser2@example.com"),
        ];
    }

    public function findById(int $id): ?User
    {
        // Placeholder implementation
        if ($id === 1) {
            return new User(1, "Database User 1", "dbuser1@example.com");
        }

        return null;
    }
}
