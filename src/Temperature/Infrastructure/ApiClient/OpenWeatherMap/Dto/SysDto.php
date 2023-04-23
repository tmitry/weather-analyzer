<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class SysDto
{
    public function __construct(
        public ?int $type,
        public ?int $id,
        public string $country,
        public int $sunrise,
        public int $sunset,
    ) {
    }
}
