<?php
namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Tests\BaseKernelTest;
use App\Controller\Admin\UserCrudController;

class UserCrudControllerTest extends BaseKernelTest
{
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
