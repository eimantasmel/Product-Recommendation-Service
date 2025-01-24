<?php

namespace App\Service;

use App\Interface\ProductRecommendationInterface;

class ProductRecommendationService implements ProductRecommendationInterface 

{
    private MeteoApiService $meteoApiService;

    public function __construct(MeteoApiService $meteoApiService)
    {
        $this->meteoApiService = $meteoApiService;
    }

    public function getRecommendations(string $city): array
    {
        try {
            $response = $this->meteoApiService->getWeatherForecast($city);
            
            return $response;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }
}
