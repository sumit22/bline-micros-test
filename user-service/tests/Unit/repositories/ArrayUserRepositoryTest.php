<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\TestCase;
use App\Repositories\User\ArrayUserRepoitory;
use App\Entities\User;

class ArrayUserRepositoryTest extends TestCase
{
    private ArrayUserRepoitory $userRepository;

    protected function setUp(): void
    {
        // Initialize the ArrayUserRepoitory before each test
        $this->userRepository = new ArrayUserRepoitory();
    }

    public function testFindByIdReturnsUser(): void
    {
        // Test finding a user by a valid ID
        $user = $this->userRepository->findById(1);

        // Assertions
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->getUserId());
        $this->assertEquals("Beverly Miller", $user->getName());
        $this->assertEquals("vanessa16@yahoo.com", $user->getEmail());
    }

    public function testFindByIdReturnsNullForNonExistentUser(): void
    {
        $user = $this->userRepository->findById(999);
        $this->assertNull($user);
    }

    public function testGetAllUsers(): void
    {
        // Test retrieving all users
        $users = $this->userRepository->getAllUsers();

        // Assertions
        $this->assertIsArray($users);
        $this->assertCount(20, $users);

        // Check the first user in the array
        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals(1, $users[0]->getUserId());
        $this->assertEquals("Beverly Miller", $users[0]->getName());
        $this->assertEquals("vanessa16@yahoo.com", $users[0]->getEmail());
    }
}
