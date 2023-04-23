<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto;

class OpenWeatherMapDto
{
    public function __construct(
        public CoordDto $coord,
        /**
         * @var WeatherDto[] $weather
         */
        public array $weather,
        public string $base,
        public MainDto $main,
        public int $visibility,
        public WindDto $wind,
        public CloudsDto $clouds,
        public int $dt,
        public SysDto $sys,
        public int $timezone,
        public int $id,
        public string $name,
        public int $cod,
    ) {
    }
}
