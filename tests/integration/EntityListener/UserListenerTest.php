<?php

namespace App\Tests\integration\EntityListener;

use App\Entity\User;
use App\EntityListener\UserListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListenerTest extends KernelTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();
    }

    public function testPrePersistWithPlainPassword(): void
    {
        $user = new User();
        $user->setPlainPassword('password');

        $userListener = $this->getContainer()->get(UserListener::class);
        $userListener->prePersist($user);

        $this->assertNotEmpty($user->getPassword());
        $this->assertStringStartsWith('$2y$', $user->getPassword());
    }

    public function testPrePersistWithNoPlainPassword(): void
    {
        $user = new User();

        $userListener = $this->getContainer()->get(UserListener::class);
        $userListener->prePersist($user);

        $this->assertEmpty($user->getPassword());
    }
}
