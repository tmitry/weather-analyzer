<?php

declare(strict_types=1);

namespace App\Temperature\Domain\Entity;

use App\Temperature\Domain\TemperatureProviderInterface;
use Symfony\Component\Uid\Uuid;

class AverageTemperature
{
    public function __construct(
        private Uuid $id,
        private Location $location,
        private ?string $avgTemperature
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function getAvgTemperature(): ?string
    {
        return $this->avgTemperature;
    }

    /**
     * @param iterable<TemperatureProviderInterface> $temperatureProviders
     * @return void
     */
    public function updateAvgTemperature(iterable $temperatureProviders): void
    {
        $count = count($temperatureProviders);
        $sum = 0;
        foreach ($temperatureProviders as $temperatureProvider) {
            $temperatureDto = $temperatureProvider->getTemperature(
                $this->getLocation()->getCountry(),
                $this->getLocation()->getCity(),
            );

            $sum += $temperatureDto->getTemperature();
        }

        $avg = $count === 0 ? 0 : round($sum / $count, 2);

        $this->avgTemperature = (string) $avg;
    }
}
