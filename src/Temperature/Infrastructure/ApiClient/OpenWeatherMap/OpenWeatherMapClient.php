<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\ApiClient\OpenWeatherMap;

use App\Temperature\Infrastructure\ApiClient\OpenWeatherMap\Dto\OpenWeatherMapDto;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class OpenWeatherMapClient
{
    private const PARAM_SECRET        = 'appid';
    private const PARAM_UNITS         = 'units';
    private const PARAM_QUERY         = 'q';
    private const UNIT_STANDARD       = 'standard';
    private const UNIT_METRIC         = 'metric';
    private const URL_WEATHER         = 'weather';
    private const URL_FORECAST_DAILY  = 'forecast/daily';
    private const URL_FORECAST_HOURLY = 'forecast/hourly';

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
    public function getWeather(string $country, string $city): OpenWeatherMapDto
    {
        $params[self::PARAM_SECRET] = $this->secret;
        $params[self::PARAM_UNITS] = self::UNIT_METRIC;
        $params[self::PARAM_QUERY] = sprintf("%s,%s", $city, $country);

        $url = sprintf(
            "%s%s?%s",
            $this->url,
            self::URL_WEATHER,
            http_build_query($params)
        );

        /** @var  OpenWeatherMapDto $openWeatherMapDto */
        $openWeatherMapDto = $this->serializer->deserialize(
            $this->httpClient->request('GET', $url)->getContent(),
            OpenWeatherMapDto::class,
            'json'
        );

        return $openWeatherMapDto;
    }
}
