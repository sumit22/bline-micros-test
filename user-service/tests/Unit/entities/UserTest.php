<?php

namespace Tests\Unit\Entities;

use PHPUnit\Framework\TestCase;
use App\Entities\User;

class UserTest extends TestCase
{
    public function testUserObjectCreation(): void
    {
        $user = new User(1, 'John Doe', 'john.doe@example.com');

        // Assertions
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->getUserId());
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john.doe@example.com', $user->getEmail());
    }

    public function testGetters(): void
    {
        $user = new User(2, 'Jane Smith', 'jane.smith@example.com');

        // Assertions
        $this->assertEquals(2, $user->getUserId());
        $this->assertEquals('Jane Smith', $user->getName());
        $this->assertEquals('jane.smith@example.com', $user->getEmail());
    }

    public function testSetters(): void
    {
        $user = new User(3, 'Alice Johnson', 'alice.johnson@example.com');

        // Use setters to update properties
        $user->setUserId(4);
        $user->setName('Bob Brown');
        $user->setEmail('bob.brown@example.com');

        // Assertions
        $this->assertEquals(4, $user->getUserId());
        $this->assertEquals('Bob Brown', $user->getName());
        $this->assertEquals('bob.brown@example.com', $user->getEmail());
    }

    public function testToArrayMethod(): void
    {
        $user = new User(5, 'Charlie Green', 'charlie.green@example.com');

        $expectedArray = [
            'userId' => 5,
            'name' => 'Charlie Green',
            'email' => 'charlie.green@example.com',
        ];

        // Assertions
        $this->assertIsArray($user->toArray());
        $this->assertEquals($expectedArray, $user->toArray());
    }
}
