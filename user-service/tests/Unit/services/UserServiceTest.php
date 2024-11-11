<?php


namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\Users\UserService;
use App\Repositories\User\UserRepositoryInterface;
use App\Entities\User;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        // Create a mock for UserRepositoryInterface
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        // Inject the mock into UserService
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function testGetAllUsers()
    {
        // Define the expected data
        $expectedUsers = [
            new User(userId: 1, name: 'John Doe', email: 'john.doe@example.com'),
            new User(userId: 2, name: 'Jane Smith', email: 'jane.smith@example.com')
        ];

        // Configure the mock to return the expected data
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('getAllUsers')
            ->willReturn($expectedUsers);

        // Call the service method
        $users = $this->userService->getAllUsers();

        // Assertions
        $this->assertIsArray($users);
        $this->assertCount(2, $users);
        $this->assertEquals($expectedUsers, $users);
        $this->assertInstanceOf(User::class, $users[0]);
    }

    public function testGetUserByIdReturnsUser()
    {
        // Define the expected user
        $expectedUser = new User(userId: 1, name: 'John Doe', email: 'john.doe@example.com');

        // Configure the mock to return the expected user
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(1))
            ->willReturn($expectedUser);

        // Call the service method
        $user = $this->userService->getUserById(1);

        // Assertions
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($expectedUser, $user);
    }

    public function testGetUserByIdReturnsNull()
    {
        // Configure the mock to return null when user is not found
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->with($this->equalTo(999))
            ->willReturn(null);

        // Call the service method with a non-existent user ID
        $user = $this->userService->getUserById(999);

        // Assertions
        $this->assertNull($user);
    }
}