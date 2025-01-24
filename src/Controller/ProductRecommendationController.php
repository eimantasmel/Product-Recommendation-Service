<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Interface\WeatherInterface;
use App\Interface\ProductRecommendationInterface;

final class ProductRecommendationController extends AbstractController
{
    private ProductRecommendationInterface $productRecommendationService;

    public function __construct(ProductRecommendationInterface $productRecommendationService)
    {
        $this->productRecommendationService = $productRecommendationService;
    }

    #[Route('/api/products/recommended/{city}', name: 'get_product_recommendations', methods: ['GET'])]
    public function index(string $city = '%default_city%'): JsonResponse
    {
        try {
            // Fetch product recomendations based on the 
            // TODO: Figure out why recommendations is note getting like expected. and then finish productrecomandation service
            // because right now it gives all forecasts and it's not compatible with products at all.
            $recommendations = $this->productRecommendationService->getRecommendations($city);

            return $this->json([
                'city' => $city,
                'recommendations' => $recommendations
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
