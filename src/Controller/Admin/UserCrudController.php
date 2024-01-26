<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $paswordHasher)
    {
        $this->passwordHasher = $paswordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('username');
        yield EmailField::new('email')->onlyOnForms();
        yield TextField::new('plainPassword')->setFormType(PasswordType::class)->onlyOnForms();
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if($entityInstance->getPlainPassword()){
            $entityInstance->setPassword('');
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
