<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductRecommendationControllerTest extends WebTestCase
{
    public function testValidCityReturnsRecommendationsKaunas(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/products/recommended/Kaunas');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('recommendations', $data);
        $this->assertSame('Kaunas', $data['city']);
        $this->assertCount(3, $data['recommendations']);
    }

    public function testValidCityReturnsRecommendationsVilnius(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/products/recommended/Vilnius');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('recommendations', $data);
        $this->assertSame('Vilnius', $data['city']);
        $this->assertCount(3, $data['recommendations']);
    }

    public function testInvalidCityReturnsBadRequest(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/products/recommended/asdf');
        $response = $client->getResponse();

        $this->assertSame(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertNotEmpty($data['error']);
    }

    public function testProductsArrayHasTwoElements(): void
    {
        $client = static::createClient();

        // Request for city "Kaunas"
        $client->request('GET', '/api/products/recommended/Kaunas');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('recommendations', $data);
        $this->assertSame('Kaunas', $data['city']);
        
        // Iterate through recommendations and check if each "products" array has 2 elements
        foreach ($data['recommendations'] as $recommendation) {
            $this->assertArrayHasKey('products', $recommendation);
            $this->assertCount(2, $recommendation['products'], 'The products array should contain exactly 2 elements.');
        }
    }
    public function testFirstRecommendationDateIsToday(): void
    {
        $client = static::createClient();

        // Request for city "Kaunas"
        $client->request('GET', '/api/products/recommended/Kaunas');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('city', $data);
        $this->assertArrayHasKey('recommendations', $data);
        $this->assertSame('Kaunas', $data['city']);
        
        // Get the date from the first recommendation
        $firstRecommendationDate = $data['recommendations'][0]['date'];

        // Get today's date in the same format (YYYY-MM-DD)
        $todayDate = (new \DateTime())->format('Y-m-d');
        
        // Check if the date of the first recommendation matches today's date
        $this->assertSame($todayDate, $firstRecommendationDate, 'The date of the first recommendation should be today.');
    }
}
