<?php
declare(strict_types=1);

namespace App\ApiClient\Weatherbit;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;

class WeatherbitClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var WeatherbitRequestFactory
     */
    private $requestFactory;

    public function __construct(ClientInterface $client, WeatherbitRequestFactory $requestFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ClientExceptionInterface
     */
    public function getCurrent(array $parameters): string
    {
        $request = $this->requestFactory->createGetCurrent($parameters);

        return $this->client->sendRequest($request)->getBody()->getContents();
    }
}
