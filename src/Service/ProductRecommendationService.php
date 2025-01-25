<?php

namespace App\Service;

use App\Interface\ProductRecommendationInterface;
use App\DTO\WeatherForecastDto;
use App\DTO\WeatherForecastWithProductsRecDto;
use App\Repository\ProductRepository;

class ProductRecommendationService implements ProductRecommendationInterface 

{
    private MeteoApiService $meteoApiService;
    private ProductRepository $productRepository;

    public function __construct(MeteoApiService $meteoApiService, ProductRepository $productRepository)
    {
        $this->meteoApiService = $meteoApiService;
        $this->productRepository = $productRepository;
    }

    public function getRecommendations(string $city, int $datesLimit = 3, int $productsLimit = 2): array
    {
        try {
            $forecasts = $this->meteoApiService->getWeatherForecast($city);
            $forecasts = array_slice($forecasts, 0, $datesLimit);

            $recommendations = [];
            foreach ($forecasts as $forecast) {
                /** @var  WeatherForecastDto $forecast */

                $weatherCondition = $forecast->getWeatherForecast(); // Example: 'cloudy', 'sunny'

                // Fetch products matching the weather condition
                $products = $this->productRepository->findByWeatherCondition($weatherCondition, $productsLimit);

                // Create the new DTO
                $recommendations[] = new WeatherForecastWithProductsRecDto($forecast, $products);
            }

            return $recommendations;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }

}
