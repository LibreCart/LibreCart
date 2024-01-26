<?php

namespace App\Tests\integration\EntityListener;

use App\Entity\User;
use App\EntityListener\UserListener;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
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

    public function testPreUpdateWithPlainPassword(): void
    {
        $user = new User();
        $user->setPlainPassword('password');

        $userListener = $this->getContainer()->get(UserListener::class);
        $userListener->preUpdate($user);

        $this->assertNotEmpty($user->getPassword());
        $this->assertStringStartsWith('$2y$', $user->getPassword());
    }

    public function testPreUpdateWithNoPlainPassword(): void
    {
        $user = new User();

        $userListener = $this->getContainer()->get(UserListener::class);
        $userListener->preUpdate($user);

        $this->assertEmpty($user->getPassword());
    }

    public function testPasswordEncryptedWhenUserFirstCreated(): void
    {
        $user = new User();
        $user->setUsername('testusername');
        $user->setPlainPassword('password');
        $user->setEmail('test@website.com');

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->persist($user);
        $entityManager->flush();

        $userRepository = $this->getContainer()->get(UserRepository::class);

        $persistedUser = $userRepository->findOneBy(['id' => $user->getId()]);

        $this->assertStringStartsWith('$2y$', $persistedUser->getPassword());
    }

    public function testPasswordEncryptedWhenUserUpdated(): void
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $user = new User();
        $user->setUsername('testusername');
        $user->setPlainPassword('password');
        $user->setEmail('test@website.com');

        $entityManager->persist($user);
        $entityManager->flush();

        $passwordUser = $user->getPassword();

        $user->setPassword("");
        $user->setPlainPassword('newPassword');

        $entityManager->persist($user);
        $entityManager->flush();

        $newPasswordUser = $user->getPassword();

        $this->assertNotSame($passwordUser, $newPasswordUser);
    }
}
