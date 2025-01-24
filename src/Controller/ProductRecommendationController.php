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

    #[Route('/api/products/recommended/{city}', name: 'get_product_recommendations', methods: ['GET'], defaults: ['city' => '%default_city%'])]
    public function index(string $city): JsonResponse
    {
        try {
            // Fetch product recomendations based on the 
            $recommendations = $this->productRecommendationService->getRecommendations($city);

            $data = [
                'city' => $city,
                'recommendations' => $recommendations,
            ];
    
            return $this->json($data);

        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
