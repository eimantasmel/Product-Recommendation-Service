<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Interface\WeatherInterface;
use App\Interface\ProductRecommendationInterface;

final class ProductRecommendationController extends AbstractController
{
    
    private WeatherInterface $weatherService;
    private ProductRecommendationInterface $productRecommendationService;

    public function __construct(WeatherInterface $weatherService, ProductRecommendationInterface $productRecommendationService)
    {
        $this->weatherService = $weatherService;
        $this->productRecommendationService = $productRecommendationService;
    }

    #[Route('/api/products/recommended/{city}', name: 'get_product_recommendations', methods: ['GET'])]
    public function index(string $city = '%default_city%'): JsonResponse
    {
        try {
            // Fetch the weather forecast for the city
            $weatherForecast = $this->weatherService->getWeatherForecast($city);

            // Generate product recommendations based on the forecast
            $recommendations = $this->productRecommendationService->getRecommendations($weatherForecast);

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
