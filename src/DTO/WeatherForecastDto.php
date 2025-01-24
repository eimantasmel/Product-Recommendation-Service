<?php

namespace App\DTO;

use DateTime;

class WeatherForecastDto
{
    private string $weatherForecast;
    private DateTime $date;
    private string $dataSource;

    public function __construct(string $weatherForecast, string $date, string $dataSource) {
        $this->weatherForecast = $weatherForecast;
        $this->date = new DateTime($date);
        $this->dataSource = $dataSource;
    }

    public function getWeatherForecast(): string
    {
        return $this->weatherForecast;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getDataSource(): string
    {
        return $this->dataSource;
    }
}