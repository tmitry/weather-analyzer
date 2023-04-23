<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\WeatherBit\Dto;

class WeatherBitDto
{
    public function __construct(
        public int $count,
        /** @var DataDto[] $data */
        public array $data,
    ) {
    }
}
