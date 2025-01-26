<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByWeatherCondition(string $condition, int $limit): array
    {
        // Fetch all products
        $products = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();

        // Filter products by condition in PHP
        $filteredProducts = array_filter($products, function (Product $product) use ($condition) {
            return in_array($condition, $product->getWeatherConditions());
        });

        // Limit the results
        return array_slice($filteredProducts, 0, $limit);
    }

}
