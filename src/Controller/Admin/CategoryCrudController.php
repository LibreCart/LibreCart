<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryTranslationType;
use App\Form\TranslationType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('urlKey'),
            ChoiceField::new('parentCategoryId')->setChoices($this->getCategoryChoices()),
            CollectionField::new('categoryTranslations')->setEntryType(CategoryTranslationType::class)->onlyOnForms()->setFormTypeOption('by_reference', false)
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if($entityInstance->getParentCategoryId()){
           $category = $this->categoryRepository->find($entityInstance->getParentCategoryId());
           
           $entityInstance->setParentCategory($category);
        }else {
            $entityInstance->setParentCategory(null);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function getCategoryChoices(): array
    {
        $categories = $this->categoryRepository->findAll();

        $choices = [];
        foreach ($categories as $category) {
            $choices[$category->getUrlKey()] = (string) $category->getId();
        }

        return $choices;
    }
}
