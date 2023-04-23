<?php

declare(strict_types=1);

namespace App\Temperature\Domain\Entity;

use Symfony\Component\Uid\Uuid;

class AverageTemperature
{
    private Uuid $id;

    private string $country;

    private string $city;

    private ?string $avg_temperature;

    public function __construct(Uuid $id, string $country, string $city, ?string $avg_temperature)
    {
        $this->id = $id;
        $this->country = $country;
        $this->city = $city;
        $this->avg_temperature = $avg_temperature;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getAvgTemperature(): ?string
    {
        return $this->avg_temperature;
    }

    public function setAvgTemperature(?string $avg_temperature): void
    {
        $this->avg_temperature = $avg_temperature;
    }
}
