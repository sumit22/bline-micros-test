<?php

// use DI\Container;
// use App\Controllers\UsersController;
// use App\Repositories\User\ArrayUserRepoitory;
// use App\Repositories\User\UserRepositoryInterface;
// use App\Services\UserService;
// use App\Services\Users\UserServiceInterface;

// $container = new Container();

// $container->set(UserRepositoryInterface::class, \DI\autowire(ArrayUserRepoitory::class));
// $container->set(UserServiceInterface::class, \DI\autowire((UserService::class)));
// $container->set(UsersController::class, \DI\autowire(UsersController::class));


// //return $container;


use App\Controllers\UsersController;
use App\Repositories\User\ArrayUserRepoitory;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceInterface;

return [
    UserRepositoryInterface::class => \DI\autowire(ArrayUserRepoitory::class),
    UserServiceInterface::class => \DI\autowire(UserService::class),
    UsersController::class => \DI\autowire(UsersController::class),
];