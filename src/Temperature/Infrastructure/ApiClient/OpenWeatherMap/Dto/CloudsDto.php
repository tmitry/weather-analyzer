<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class CloudsDto
{
    public function __construct(
        public int $all
    ) {
    }
}
