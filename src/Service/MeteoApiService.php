<?php

namespace App\Service;

use App\Interface\WeatherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\DTO\WeatherForecastDto;
use App\Constant\MeteoApiConstants;


class MeteoApiService implements WeatherInterface
{
    private HttpClientInterface $httpClient;
    private string $apiUrl;
    private const DATA_SOURCE = 'Data provided by LHMT (api.meteo.lt)';

    public function __construct(HttpClientInterface $httpClient, string $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->apiUrl = $apiUrl;
    }

    public function getWeatherForecast(string $city): array
    {   

        $url = str_replace('{city}', strtolower($city), $this->apiUrl);

        try {
            $response = $this->httpClient->request('GET', $url);
            $data = $response->toArray();

            $forecasts = [];

            foreach ($data['forecastTimestamps'] as $forecast) {

                $weatherDto = new WeatherForecastDto($forecast[MeteoApiConstants::CONDITION_CODE],
                                                     $forecast[MeteoApiConstants::FORECAST_TIME_UTC],
                                                     self::DATA_SOURCE);

                $forecasts[] = $weatherDto;
            }

            return $forecasts;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }
}