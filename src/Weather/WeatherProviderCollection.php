<?php
declare(strict_types=1);

namespace App\Weather;

class WeatherProviderCollection
{
    /**
     * @var array
     */
    private $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = iterator_to_array($providers);
    }

    public function getAvgTemperature(string $country, string $city): float
    {
        $temperatures = [];
        /** @var WeatherInterface $provider */
        foreach ($this->providers as $provider) {
            $temperatures[] = $provider->getTemperature($country, $city);
        }

        if ($temperatures) {
            return array_sum($temperatures) / count($temperatures);
        }

        return 0;
    }
}