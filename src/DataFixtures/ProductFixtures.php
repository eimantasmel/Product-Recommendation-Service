<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Product;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setSku($faker->regexify('[A-Z]{2}-\d{3}'));
            $product->setName($faker->words(3, true));
            $product->setPrice($faker->randomFloat(2, 1, 100)); // Price between 1.00 and 100.00

            $manager->persist($product);
        }

        $manager->flush();
    }
}
