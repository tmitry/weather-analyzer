<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\WeatherBit\Dto;

class WeatherDto
{
    public function __construct(
        public int $code,
        public string $icon,
        public string $description,
    ) {
    }
}
