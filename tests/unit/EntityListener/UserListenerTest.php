<?php

namespace App\Tests\unit\EntityListener;

use App\Entity\User;
use App\EntityListener\UserListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListenerTest extends TestCase
{
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        parent::setUp();

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $passwordHasher->expects(static::any())
            ->method('hashPassword')
            ->willReturn('hashed-password');

        $this->passwordHasher = $passwordHasher;
    }


    public function testPrePersistWithPlainPassword(): void
    {
        $user = new User();
        $user->setPlainPassword('password');

        $userListener = new UserListener($this->passwordHasher);
        $userListener->prePersist($user);

        $this->assertSame('hashed-password', $user->getPassword());
    }

    public function testPrePersistWithEmptyPlainPassword(): void
    {
        $user = new User();

        $userListener = new UserListener($this->passwordHasher);
        $userListener->prePersist($user);

        $this->assertEmpty($user->getPassword());
    }
}
