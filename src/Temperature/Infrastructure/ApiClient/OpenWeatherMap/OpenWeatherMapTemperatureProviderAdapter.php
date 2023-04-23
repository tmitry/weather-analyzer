<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap;

use App\Temperature\Application\Command\CalculateAverageTemperature\Dto\TemperatureDto;
use App\Temperature\Application\Command\CalculateAverageTemperature\TemperatureProviderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class OpenWeatherMapTemperatureProviderAdapter implements TemperatureProviderInterface
{
    public function __construct(
        private OpenWeatherMapClient $client
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
        $openWeatherMapDto = $this->client->getWeather($country, $city);

        return new TemperatureDto($openWeatherMapDto->main->temp);
    }
}