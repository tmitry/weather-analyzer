<?php
declare(strict_types=1);

namespace App\Weather\Provider;

use App\ApiClient\Weatherbit\WeatherbitClient;
use App\Weather\Exception\WeatherException;
use App\Weather\WeatherInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Contracts\Cache\CacheInterface;

class WeatherbitAdapter implements WeatherInterface
{
    /**
     * @var WeatherbitClient
     */
    private $client;

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(WeatherbitClient $client, CacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * @param string $country
     * @param string $city
     * @return float
     * @throws WeatherException
     */
    public function getTemperature(string $country, string $city): float
    {
        $parameters = [
            // Don't find Poland
//            'country'   => $country,
            'city'      => $city
        ];

        $avgTemperature = $this->cache->getItem('weatherbit.avg_temperature.' . $country . '_' . $city);
        if ($avgTemperature->isHit()) {
            return $avgTemperature->get();
        }

        try {
            $response = $this->client->getCurrent($parameters);
        } catch (ClientExceptionInterface $e) {
            throw new WeatherException("Failed to get weather.", 0, $e);
        }

        $data = json_decode($response, true);

        if (empty($data['data']['0']['temp'])) {
            throw new WeatherException("Failed to get temperature.");
        }

        $avgTemperature->set($data['data']['0']['temp']);
        $avgTemperature->expiresAfter(60 * 60);
        $this->cache->save($avgTemperature);

        return $data['data']['0']['temp'];
    }
}
