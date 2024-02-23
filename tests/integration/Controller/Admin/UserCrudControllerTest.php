<?php

namespace App\Tests\integration\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Controller\Admin\UserCrudController;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudControllerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();
    }

    public function testUpdateEntityHasEncryptedPassword(): void
    {
        $user = new User();
        $user->setUsername('username');
        $user->setEmail('email@testweb.com');
        $user->setPlainPassword('password');

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $entityManager->persist($user);
        $entityManager->flush();

        $oldPassword = $user->getPassword();

        $user->setPlainPassword('newPassword');

        $userCrudController = new UserCrudController();
        $userCrudController->updateEntity($entityManager, $user);

        $newPassword = $user->getPassword();

        $this->assertStringStartsWith('$2y$', $user->getPassword());
        $this->assertNotSame($newPassword,$oldPassword);
    }
}
