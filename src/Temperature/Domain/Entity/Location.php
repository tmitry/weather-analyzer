<?php

declare(strict_types=1);

namespace App\Temperature\Domain\Entity;

readonly class Location
{
    public function __construct(
        private string $country,
        private string $city
    ) {
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}