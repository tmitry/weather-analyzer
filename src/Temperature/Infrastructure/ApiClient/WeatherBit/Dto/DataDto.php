<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\WeatherBit\Dto;

class DataDto
{
    public function __construct(
        public float $app_temp,
        public int $aqi,
        public string $city_name,
        public int $clouds,
        public string $country_code,
        public string $datetime,
        public float $dewpt,
        public float $dhi,
        public float $dni,
        public float $elev_angle,
        public float $ghi,
        public float $gust,
        public float $h_angle,
        public float $lat,
        public float $lon,
        public string $ob_time,
        public string $pod,
        public float $precip,
        public float $pres,
        public int $rh,
        public float $slp,
        public int $snow,
        public float $solar_rad,
        /** @var string[] $sources */
        public array $sources,
        public string $state_code,
        public string $station,
        public string $sunrise,
        public string $sunset,
        public float $temp,
        public string $timezone,
        public int $ts,
        public float $uv,
        public int $vis,
        public WeatherDto $weather,
        public string $wind_cdir,
        public string $wind_cdir_full,
        public int $wind_dir,
        public float $wind_spd,
    ) {
    }
}