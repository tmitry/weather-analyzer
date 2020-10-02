<?php
declare(strict_types=1);

namespace App\ApiClient\OpenWeatherMap;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;

class OpenWeatherMapClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var OpenWeatherMapRequestFactory
     */
    private $requestFactory;

    public function __construct(ClientInterface $client, OpenWeatherMapRequestFactory $requestFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ClientExceptionInterface
     */
    public function getWeather(array $parameters): string
    {
        $request = $this->requestFactory->createGetWeather($parameters);

        return $this->client->sendRequest($request)->getBody()->getContents();
    }
}
