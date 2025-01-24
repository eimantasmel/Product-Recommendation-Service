<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Constant\ConditionCodes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    private const PRODUCTS_AMOUNT = 500;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $weatherConditions = ConditionCodes::getAll(); // Get all possible weather conditions

        for ($i = 0; $i < self::PRODUCTS_AMOUNT; $i++) {
            $product = new Product();
            $product->setSku($faker->regexify('[A-Z]{2}-\d{3}'));
            $product->setName($faker->words(3, true));
            $product->setPrice($faker->randomFloat(2, 1, 100)); // Price between 1.00 and 100.00

            // Assign multiple random weather conditions (e.g., 1–3 conditions per product)
            $randomConditions = $faker->randomElements($weatherConditions, rand(1, 3));
            $product->setWeatherConditions($randomConditions);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
