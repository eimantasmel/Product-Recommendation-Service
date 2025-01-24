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

    public function getRecommendations(string $city, int $datesLimit = 3, int $productsLimit = 2): array
    {
        try {
            $forecasts = $this->meteoApiService->getWeatherForecast($city);
            $forecasts = array_slice($forecasts, 0, $datesLimit);
            

            return $forecasts;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }

}
