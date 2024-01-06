<?php

namespace App\DataFixtures;

use App\Entity\Product;
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
            $product->setName($faker->name());
            $product->setPrice($faker->randomNumber());
            $product->setEan($faker->ean13());
            $product->setStock($faker->randomDigit());

            $manager->persist($product);
        }


        $manager->flush();
    }
}
