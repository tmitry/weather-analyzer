<?php

namespace App\Entity;

use App\Repository\TemperatureRepository;
use App\Weather\WeatherProviderCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TemperatureRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Temperature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="float")
     */
    private $avg_temperature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAvgTemperature(): ?float
    {
        return $this->avg_temperature;
    }

    public function setAvgTemperature(float $avg_temperature): self
    {
        $this->avg_temperature = $avg_temperature;

        return $this;
    }
}
