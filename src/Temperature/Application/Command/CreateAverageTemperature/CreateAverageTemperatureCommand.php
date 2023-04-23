<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\CreateAverageTemperature;

class CreateAverageTemperatureCommand
{
    private string $country;

    private string $city;

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
}