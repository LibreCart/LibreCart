<?php

namespace App\Form;

use App\Entity\CategoryTranslation;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryTranslationType extends TranslationType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryTranslation::class,
        ]);
    }
}
