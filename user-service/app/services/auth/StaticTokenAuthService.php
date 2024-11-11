<?php

namespace App\Services\Auth;

use Psr\Http\Message\ServerRequestInterface as Request;

class StaticTokenAuthService implements AuthServiceInterface {

    public function authenticate(Request $request): bool {

        $staticToken = $_ENV['STATIC_API_KEY'] ?: throw new \Exception("Something went wrong", 500);
        return $staticToken === $this->getBearerToken($request);
    }


    private function getBearerToken(Request $request): ?string
    {
        // Get the Authorization header
        $authHeader = $request->getHeaderLine('Authorization');
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1]; // Return the token string
        }
        return null;
    }
}