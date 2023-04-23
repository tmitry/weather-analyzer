<?php

namespace App\Temperature\Application\Command\CalculateAverageTemperature;

use App\Temperature\Application\Command\CalculateAverageTemperature\Dto\TemperatureDto;

interface TemperatureProviderInterface
{
    public function getTemperature(string $country, string $city): TemperatureDto;
}