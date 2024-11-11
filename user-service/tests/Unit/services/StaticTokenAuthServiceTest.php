<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\Auth\StaticTokenAuthService;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class StaticTokenAuthServiceTest extends TestCase
{
    private StaticTokenAuthService $authService;

    protected function setUp(): void
    {
        $this->authService = new StaticTokenAuthService();
        $_ENV['STATIC_API_KEY'] = 'test-static-api-key';
    }

    public function testAuthenticateWithValidToken(): void
    {
        // Create a mock request with a valid Authorization header
        $request = ServerRequestFactory::createFromGlobals()
            ->withHeader('Authorization', 'Bearer test-static-api-key');

        // Assert that the authentication is successful
        $this->assertTrue($this->authService->authenticate($request));
    }

    public function testAuthenticateWithInvalidToken(): void
    {
        // Create a mock request with an invalid Authorization header
        $request = ServerRequestFactory::createFromGlobals()
            ->withHeader('Authorization', 'Bearer invalid-token');

        // Assert that the authentication fails
        $this->assertFalse($this->authService->authenticate($request));
    }

    public function testAuthenticateWithMissingToken(): void
    {
        // Create a mock request without an Authorization header
        $request = ServerRequestFactory::createFromGlobals();

        // Assert that the authentication fails
        $this->assertFalse($this->authService->authenticate($request));
    }

    public function testAuthenticateThrowsExceptionWhenEnvNotSet(): void
    {
        // Unset the STATIC_API_KEY environment variable
        unset($_ENV['STATIC_API_KEY']);

        // Expect an exception to be thrown
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Something went wrong');

        // Create a mock request
        $request = ServerRequestFactory::createFromGlobals();

        // Call the authenticate method, which should throw an exception
        $this->authService->authenticate($request);
    }
}