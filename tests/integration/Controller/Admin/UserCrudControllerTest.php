<?php

namespace App\Tests\integration\Controller\Admin;

use App\Controller\Admin\UserCrudController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudControllerTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testPersistEntityPasswordIsHashed(): void
    {
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $passwordHasher->expects(static::once())
            ->method('hashPassword')
            ->willReturn("testpassword-encrypted");

        $user = new User();
        $user->setUsername('testuser');
        $user->setEmail('testuser@example.com');
        $user->setPlainPassword('testpassword');

        $controller = new UserCrudController($passwordHasher);
        $controller->persistEntity($entityManager, $user);

        $this->assertSame("testpassword-encrypted", $user->getPassword());
    }
}
