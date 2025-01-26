<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'Products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(type: 'string', nullable: false, length: 10)]
    private string $sku;

    #[ORM\Column(type: 'string', nullable: false, length: 255)]
    private string $name;

    #[ORM\Column(name: 'price', type: 'decimal', precision: 7, scale: 2)]
    private float $price;

    #[ORM\Column(type: 'json')]
    private array $weatherConditions = []; // Conditions like ['cloudy', 'sunny']

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getWeatherConditions(): array
    {
        return $this->weatherConditions;
    }

    public function setWeatherConditions(array $conditions): self
    {
        $this->weatherConditions = $conditions;
        return $this;
    }
}
