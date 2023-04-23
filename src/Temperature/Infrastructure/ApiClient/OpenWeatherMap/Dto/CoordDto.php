<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class CoordDto
{
    public function __construct(
        public float $lon,
        public float $lat,
    ) {
    }
}
