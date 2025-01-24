<?php 

namespace App\Interface;

interface ProductRecommendationInterface
{
    public function getRecommendations(string $city) : array;
}
