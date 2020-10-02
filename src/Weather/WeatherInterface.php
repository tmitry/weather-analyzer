<?php
declare(strict_types=1);

namespace App\Weather;

interface WeatherInterface
{
    public function getTemperature(string $country, string $city): float;
}