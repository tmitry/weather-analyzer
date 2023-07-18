<?php

declare(strict_types=1);

namespace App\Temperature\Domain\Dto;

class TemperatureDto
{
    public function __construct(
        public float $temperature
    ) {
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }
}