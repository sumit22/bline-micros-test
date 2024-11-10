<?php

namespace App\Http\Controllers;

use App\Services\Users\UserServiceInterface;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\ArrayUtils;

class UsersController {

    public function __construct(private UserServiceInterface $userService){}

    public function index(ServerRequestInterface $request, ResponseInterface $response) {
        

        // Retrieve query parameters (e.g., ?page=2&perPage=5)
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        $perPage = $queryParams['perPage'] ?? 10;
        
        $users = array_map(fn($user) => $user->toArray(), $this->userService->getAllUsers());
        $paginatedUsers = ArrayUtils::paginateArray($users, $page, $perPage);


        $response->getBody()->write(json_encode($paginatedUsers));
        $response->withStatus(200);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getUserById(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface
    {

        $id = (int) $id;
        $user = $this->userService->getUserById($id);

        if (!$user) {
            //die("no user found");
            throw new \App\Exceptions\ResourceNotFoundException($request, $id, "User");
        }

        // Write the JSON-encoded user to the response body
        $response->getBody()->write(json_encode($user->toArray()));

        // Return the response with a JSON content type
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}