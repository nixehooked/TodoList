<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private $user;

    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->user->setId(1);
        $this->assertSame(1, $this->user->getId());
    }

    public function testUsername(): void
    {
        $this->user->setUsername('Bob');
        $this->assertSame('Bob', $this->user->getUsername());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('azertyui');
        $this->assertSame('azertyui', $this->user->getPassword());
    }

    public function testEmail(): void
    {
        $this->user->setEmail('root@root.fr');
        $this->assertSame('root@root.fr', $this->user->getEmail());
    }

    public function testRoles(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testTasks(): void
    {
        $tasks = $this->user->getTasks($this->task->getUser());
        $this->assertSame($this->user->getTasks(), $tasks);

        $this->user->addtask($this->task);
        $this->assertCount(1, $this->user->getTasks());

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTasks());
    }


    public function testSalt(): void
    {
        $this->assertEquals(null, $this->user->getSalt());
    }

    public function testEraseCredential(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

}