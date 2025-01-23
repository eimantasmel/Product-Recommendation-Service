<?php 

namespace App\Interface;

interface WeatherInterface
{
    public function getWeatherForecast(string $weatherForecast) : array;
}
