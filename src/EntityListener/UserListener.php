<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

//#[AsEventListener]
class UserListener
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(User $user): void
    {
        $this->handlePassword($user);
    }

    public function preUpdate(User $user): void
    {
        $this->handlePassword($user);
    }

    private function handlePassword(User $user)
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
        }
    }
}
