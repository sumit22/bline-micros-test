<?php

namespace App\Services\Auth;

use Psr\Http\Message\ServerRequestInterface as Request;

interface AuthServiceInterface {

    public function authenticate(Request $request): bool;
}