<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class MainDto
{
    public function __construct(
        public float $temp,
        public float $feels_like,
        public float $temp_min,
        public float $temp_max,
        public int $pressure,
        public int $humidity,
    ) {
    }
}
