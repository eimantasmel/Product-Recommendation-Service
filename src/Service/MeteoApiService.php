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

            $forecasts = $data[MeteoApiConstants::FORECAST_TIMESTAMPS] ?? [];

            // Group data by days
            $groupedData = $this->groupDataByDays($forecasts);

            // Build WeatherForecastDto for each day with the most frequent condition code
            $dailyForecasts = [];
            foreach ($groupedData as $date => $conditions) {
                $mostFrequentCondition = $this->findMostFrequentConditionCode($conditions);

                $dailyForecasts[] = new WeatherForecastDto(
                    $mostFrequentCondition,
                    $date,
                    self::DATA_SOURCE
                );
            }

            return $dailyForecasts;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: ' . $e->getMessage());
        }
    }

    /**
     * Groups forecast data by day.
     *
     * @param array $forecasts
     * @return array
     */
    private function groupDataByDays(array $forecasts): array
    {
        $groupedData = [];

        foreach ($forecasts as $forecast) {
            $date = (new \DateTime($forecast[MeteoApiConstants::FORECAST_TIME_UTC]))->format('Y-m-d');

            if (!isset($groupedData[$date])) {
                $groupedData[$date] = [];
            }

            $groupedData[$date][] = $forecast[MeteoApiConstants::CONDITION_CODE];
        }

        return $groupedData;
    }

    /**
     * Finds the most frequent condition code in an array.
     *
     * @param array $conditions
     * @return string
     */
    private function findMostFrequentConditionCode(array $conditions): string
    {
        $frequency = array_count_values($conditions);
        arsort($frequency);

        return array_key_first($frequency);
    }
}
