<?php

declare(strict_types=1);

namespace App\Temperature\Domain\Entity;

use Symfony\Component\Uid\Uuid;

class AverageTemperature
{
    private Uuid $id;

    private Location $location;

    private ?string $avgTemperature;

    public function __construct(Uuid $id, Location $location, ?string $avgTemperature)
    {
        $this->id = $id;
        $this->location = $location;
        $this->avgTemperature = $avgTemperature;
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

    public function setAvgTemperature(?string $avgTemperature): void
    {
        $this->avgTemperature = $avgTemperature;
    }
}
