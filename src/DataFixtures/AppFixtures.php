<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductTranslation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::Create();

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setPrice($faker->randomNumber());
            $product->setEan($faker->ean13());
            $product->setStock($faker->randomDigit());

            $translation = new ProductTranslation();
            $translation->setProduct($product);
            $translation->setLocale('en_US');
            $translation->setName($faker->name);
            $translation->setDescription($faker->text);
            $translation->setEnabled(1);

            $manager->persist($product);
            $manager->persist($translation);
        }


        $manager->flush();
    }
}
