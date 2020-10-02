<?php
declare(strict_types=1);

namespace App\ApiClient\Weatherbit;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class WeatherbitRequestFactory
{
    /**
     * @var string
     */
    private $apiKey;

    private const PARAM_API_KEY         = 'key';
    private const PARAM_UNITS           = 'units';

    private const UNIT_FAHRENHEIT       = 'I';
    private const UNIT_METRIC           = 'M';

    private const URI_BASE              = 'https://api.weatherbit.io/v2.0/';

    private const URI_CURRENT           = 'current';
    private const URI_ALERTS            = 'alerts';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function createGetCurrent(array $parameters): RequestInterface
    {
        $uri = $this->buildUri(self::URI_CURRENT, $parameters);

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
