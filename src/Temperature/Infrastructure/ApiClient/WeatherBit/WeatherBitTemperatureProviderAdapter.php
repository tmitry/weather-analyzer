<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\WeatherBit;

use App\Temperature\Domain\Dto\TemperatureDto;
use App\Temperature\Domain\TemperatureProviderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class WeatherBitTemperatureProviderAdapter implements TemperatureProviderInterface
{
    public function __construct(
        private WeatherBitClient $client
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTemperature(string $country, string $city): TemperatureDto
    {
        $weatherBitDto = $this->client->getCurrent($city);

        return new TemperatureDto($weatherBitDto->data[0]->temp);
    }
}