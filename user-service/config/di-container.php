<?php

use App\Http\Controllers\UsersController;
use App\Http\Middlewares\AuthMiddleware;
use App\Repositories\User\ArrayUserRepoitory;
use App\Repositories\User\DBUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Auth\StaticTokenAuthService;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceInterface;
use Dotenv\Dotenv;

// Load environment variables
//$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
//$dotenv->safeLoad();



//future switching between different user providers
// $persistenceType = getenv('PERSISTENCE_MODE') ?? 'static';

// $userRepository = $persistenceType === 'static'
//     ? \DI\autowire(ArrayUserRepoitory::class)
//     : \DI\autowire(DBUserRepository::class);

return [
    AuthServiceInterface::class => \DI\autowire(StaticTokenAuthService::class),
    UserRepositoryInterface::class => \DI\autowire(ArrayUserRepoitory::class),
    UserServiceInterface::class => \DI\autowire(UserService::class),
    AuthMiddleware::class => \DI\autowire(AuthMiddleware::class),
    UsersController::class => \DI\autowire(UsersController::class),
];