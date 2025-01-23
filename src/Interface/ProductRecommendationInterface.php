<?php 

namespace App\Interface;

interface ProductRecommendationInterface
{
    public function getRecommendations(array $weatherForecast) : array;
}
