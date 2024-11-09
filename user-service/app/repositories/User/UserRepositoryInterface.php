<?php

namespace App\Repositories\User;

use App\Entities\User;

interface UserRepositoryInterface {
    public function findById(int $id): ?User;
    public function getAllUsers(): array;
}