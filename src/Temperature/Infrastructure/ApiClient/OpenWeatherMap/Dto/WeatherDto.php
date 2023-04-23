<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class WeatherDto
{
    public function __construct(
        public int $id,
        public string $main,
        public string $description,
        public string $icon,
    ) {
    }
}
