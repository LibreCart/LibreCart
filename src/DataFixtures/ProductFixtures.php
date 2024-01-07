<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\ProductTranslation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
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
