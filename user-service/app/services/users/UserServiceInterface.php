<?php

namespace App\Services\Users;

use App\Entities\User;

interface UserServiceInterface{

    public function getAllUsers():Array;
    public function getUserById(int $id):?User;
}