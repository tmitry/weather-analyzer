<?php

namespace App\Temperature\Domain;

use App\Temperature\Domain\Dto\TemperatureDto;

interface TemperatureProviderInterface
{
    public function getTemperature(string $country, string $city): TemperatureDto;
}