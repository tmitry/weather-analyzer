<?php
declare(strict_types=1);

namespace App\ApiClient\OpenWeatherMap;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class OpenWeatherMapRequestFactory
{
    /**
     * @var string
     */
    private $apiKey;

    private const PARAM_API_KEY         = 'appid';
    private const PARAM_UNITS           = 'units';

    private const UNIT_STANDARD         = 'standard';
    private const UNIT_METRIC           = 'metric';

    private const URI_BASE              = 'https://api.openweathermap.org/data/2.5/';

    private const URI_WEATHER           = 'weather';
    private const URI_FORECAST_DAILY    = 'forecast/daily';
    private const URI_FORECAST_HOURLY   = 'forecast/hourly';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function createGetWeather(array $parameters): RequestInterface
    {
        $uri = $this->buildUri(self::URI_WEATHER, $parameters);

        return new Request('GET', $uri);
    }

    private function buildUri(string $uri, array $parameters = []): string
    {
        $uri = self::URI_BASE . $uri;

        $parameters[self::PARAM_API_KEY] = $this->apiKey;
        $parameters[self::PARAM_UNITS] = self::UNIT_METRIC;

        $uri .= "?" . http_build_query($parameters);

        return $uri;
    }
}
