<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\WeatherBit;

use App\Temperature\Infrastructure\ApiClient\WeatherBit\Dto\WeatherBitDto;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherBitClient
{
    private const PARAM_API_KEY   = 'key';
    private const PARAM_UNITS     = 'units';
    private const PARAM_CITY      = 'city';
    private const UNIT_FAHRENHEIT = 'I';
    private const UNIT_METRIC     = 'M';
    private const URL_CURRENT     = 'current';
    private const URL_ALERTS      = 'alerts';

    public function __construct(
        private string $url,
        private string $secret,
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCurrent(string $city): WeatherBitDto
    {
        $params[self::PARAM_API_KEY] = $this->secret;
        $params[self::PARAM_UNITS] = self::UNIT_METRIC;
        $params[self::PARAM_CITY] = $city;

        $url = sprintf(
            "%s%s?%s",
            $this->url,
            self::URL_CURRENT,
            http_build_query($params)
        );

        /** @var  WeatherBitDto $weatherBitDto */
        $weatherBitDto = $this->serializer->deserialize(
            $this->httpClient->request('GET', $url)->getContent(),
            WeatherBitDto::class,
            'json'
        );

        return $weatherBitDto;
    }
}
