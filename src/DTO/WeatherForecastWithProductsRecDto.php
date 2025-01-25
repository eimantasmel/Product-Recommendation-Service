<?php

namespace App\DTO;

class WeatherForecastWithProductsRecDto implements \JsonSerializable
{
    private WeatherForecastDto $forecast;
    private array $products;

    public function __construct(WeatherForecastDto $forecast, array $products)
    {
        $this->forecast = $forecast;
        $this->products = $products;
    }

    public function getForecast(): WeatherForecastDto
    {
        return $this->forecast;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            $this->forecast->jsonSerialize(), // Include properties of forecast directly
            [
                'products' => array_map(fn($product) => [
                    'sku' => $product->getSku(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                ], $this->products),
            ]
        );
    }
}
