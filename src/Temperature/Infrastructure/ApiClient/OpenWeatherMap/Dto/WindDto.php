<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class WindDto
{
    public function __construct(
        public float $speed,
        public int $deg,
    ) {
    }
}
