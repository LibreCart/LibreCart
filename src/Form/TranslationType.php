<?php 

namespace App\Form;

use App\Enum\LocaleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('locale', ChoiceType::class,  [
            'choices' => LocaleEnum::toArray(),
            'placeholder' => LocaleEnum::en_US->name,
        ])
        ->add('name', TextType::class)
        ->add('description', TextType::class);
    }
}