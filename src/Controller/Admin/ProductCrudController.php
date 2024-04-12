<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductTranslationType;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('urlKey'),
            MoneyField::new('price')->setCurrency('EUR'),
            IntegerField::new('ean'),
            IntegerField::new('stock'),
            AssociationField::new('categories')
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms()
                ->setCrudController(CategoryCrudController::class),
            CollectionField::new('productTranslations')
                ->setEntryType(ProductTranslationType::class)
                ->onlyOnForms()
                ->setFormTypeOption('by_reference', false)
        ];
    }
}
