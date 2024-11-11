<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\UsersController;
use PHPUnit\Framework\TestCase;
use DI\Container;
use DI\ContainerBuilder;
use App\Services\Users\UserServiceInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;
use Slim\Psr7\Factory\UriFactory;

class UserControllerTest extends TestCase
{

    //private UserServiceInterface $userService;
    private UsersController $userController;
    private Container $container;
    protected function setUp(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions("./config/di-container.php");

        $this->container = $builder->build();

        $this->userController = $this->container->get(UsersController::class);
    }

    public function testGetAllUsers()
    {
        $uriFactory = new UriFactory();
        $uri = $uriFactory->createUri('/users');

        $request = ServerRequestFactory::createFromGlobals()->withMethod("GET")->withUri($uri);
        $response = new Response();
        $usersResponse = $this->userController->index($request, $response);


        $this->assertEquals(200, $usersResponse->getStatusCode());

        $this->assertJson($usersResponse->getBody()->__toString());
        $this->assertEquals('application/json', $usersResponse->getHeaderLine('Content-Type'));


        $responseData = json_decode($usersResponse->getBody()->__toString(), true);
        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        $this->assertArrayHasKey('userId', $responseData['data'][0]);
        $this->assertArrayHasKey('name', $responseData['data'][0]);
        $this->assertArrayHasKey('email', $responseData['data'][0]);

    }


    public function testGetUserByID(): void
    {
        $uriFactory = new UriFactory();
        $uri = $uriFactory->createUri('/users');

        $request = ServerRequestFactory::createFromGlobals()->withMethod("GET")->withUri($uri);
        $response = new Response();
        $usersResponse = $this->userController->getUserById($request, $response, 1);
        $this->assertEquals(200, $usersResponse->getStatusCode());
        $this->assertJson($usersResponse->getBody()->__toString());
        $this->assertEquals('application/json', $usersResponse->getHeaderLine('Content-Type'));


        $responseData = json_decode($usersResponse->getBody()->__toString(), true);


        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);
        $this->assertArrayHasKey('userId', $responseData);
        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('email', $responseData);

    }
    public function testUserNotFoundError(): void
    {
        $this->expectException(\App\Exceptions\ResourceNotFoundException::class);
        $this->expectExceptionMessage('Resource User with ID 10000 was not found.');

        $uriFactory = new UriFactory();
        $uri = $uriFactory->createUri('/users/10000');

        // Create a GET request with the specified URI
        $request = ServerRequestFactory::createFromGlobals()->withMethod("GET")->withUri($uri);
        $response = new Response();

        // Call the method that is expected to throw the exception
        $this->userController->getUserById($request, $response, 10000);
    }
}