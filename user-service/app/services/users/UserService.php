<?php

namespace App\Services\Users;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\Users\UserServiceInterface;
use App\Entities\User;

class UserService implements UserServiceInterface {

    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById(int $id): ?User
    {
        //die('id in service :' . $id .'');
        return $this->userRepository->findById($id);
    }
}