<?php

namespace App\Service;

use App\Interface\WeatherInterface;


class WeatherService implements WeatherInterface
{
    public function getWeatherForecast(string $city) : array
    {
        return [];
    }
}