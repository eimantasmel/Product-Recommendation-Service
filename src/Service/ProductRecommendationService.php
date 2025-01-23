<?php

namespace App\Service;

use App\Interface\ProductRecommendationInterface;

class ProductRecommendationService implements ProductRecommendationInterface 
{
    public function getRecommendations(array $weatherForecast) : array
    {
        return ['test'];
    }
}