<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends BaseEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void 
    {
        foreach( $roles as $role ) {
            if (!in_array($role, UserRoleEnum::toArray())){
                return;
            }
        }

        $this->roles = $roles;
    }

    public function addRole(UserRoleEnum $userRole): void 
    {
        if (!in_array($userRole->name, $this->roles)){
            $this->roles[] = $userRole->name;
        }
    }

    public function removeRole(UserRoleEnum $userRole): void 
    {
        $key = array_search($userRole->name, $this->roles);

        if ($key) {
            unset($this->roles[$key]);
        }
    }

    public function eraseCredentials(): void
    {
        $this->setPlainPassword('');
    }

    public function getUserIdentifier(): string
    {
        return "";
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedPassword(): void {
        if ($this->getPlainPassword() !== null) {
            $this->setPassword(password_hash($this->plainPassword, PASSWORD_DEFAULT));
        }
    }
}
