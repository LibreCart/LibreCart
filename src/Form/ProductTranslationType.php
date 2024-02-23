<?php

namespace App\Form;

use App\Entity\ProductTranslation;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductTranslationType extends TranslationType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductTranslation::class,
        ]);
    }
}
