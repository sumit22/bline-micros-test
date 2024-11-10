<?php

namespace App\Http\Middlewares;

use App\Services\Auth\AuthServiceInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class AuthMiddleware implements MiddlewareInterface
{

    public function __construct(private AuthServiceInterface $authService)
    {
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
        if (!$this->authService->authenticate($request)) {

            throw new HttpUnauthorizedException($request, "Unauthorized request");
        }

        return $handler->handle($request);
    }

    




}