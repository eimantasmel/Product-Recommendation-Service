<?php

namespace App\Service;

use App\Interface\ProductRecommendationInterface;
use App\DTO\WeatherForecastDto;
use App\DTO\WeatherForecastWithProductsRecDto;
use App\Repository\ProductRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductRecommendationService implements ProductRecommendationInterface 

{
    private const CACHE_EXPIRATION = 300;

    private MeteoApiService $meteoApiService;
    private ProductRepository $productRepository;
    private CacheInterface $cache;

    public function __construct(MeteoApiService $meteoApiService, 
                                ProductRepository $productRepository,
                                CacheInterface $cache)
    {
        $this->meteoApiService = $meteoApiService;
        $this->productRepository = $productRepository;
        $this->cache = $cache;
    }
    public function getRecommendations(string $city, int $datesLimit = 3, int $productsLimit = 2): array
    {
        try {
            // Generate a unique cache key based on input parameters
            $cacheKey = sprintf('recommendations_%s_%d_%d', $city, $datesLimit, $productsLimit);
    
            // Check cache or store data if not present
            return $this->cache->get($cacheKey, function (ItemInterface $item) use ($city, $datesLimit, $productsLimit) {
                $item->expiresAfter(self::CACHE_EXPIRATION); // Cache for 5 minutes (300 seconds)
    
                // Fetch forecasts
                $forecasts = $this->meteoApiService->getWeatherForecast($city);
                $forecasts = array_slice($forecasts, 0, $datesLimit);
    
                // Build recommendations
                $recommendations = [];
                foreach ($forecasts as $forecast) {
                    /** @var WeatherForecastDto $forecast */
                    $weatherCondition = $forecast->getWeatherForecast();
                    $products = $this->productRepository->findByWeatherCondition($weatherCondition, $productsLimit);
                    $recommendations[] = new WeatherForecastWithProductsRecDto($forecast, $products);
                }
    
                return $recommendations;
            });
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }

}
