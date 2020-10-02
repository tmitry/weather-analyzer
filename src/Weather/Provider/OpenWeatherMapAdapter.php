<?php
declare(strict_types=1);

namespace App\Weather\Provider;

use App\ApiClient\OpenWeatherMap\OpenWeatherMapClient;
use App\Weather\Exception\WeatherException;
use App\Weather\WeatherInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Contracts\Cache\CacheInterface;

class OpenWeatherMapAdapter implements WeatherInterface
{
    /**
     * @var OpenWeatherMapClient
     */
    private $client;

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(OpenWeatherMapClient $client, CacheInterface $cache)
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
            'q' => $city
        ];

        try {
            $response = $this->client->getWeather($parameters);
        } catch (ClientExceptionInterface $e) {
            throw new WeatherException("Failed to get weather.", 0, $e);
        }

        $avgTemperature = $this->cache->getItem('openweathermap.avg_temperature.' . $country . '_' . $city);
        if ($avgTemperature->isHit()) {
            return $avgTemperature->get();
        }

        $data = json_decode($response, true);

        if (empty($data['main']['temp'])) {
            throw new WeatherException("Failed to get temperature.");
        }

        $avgTemperature->set($data['main']['temp']);
        $avgTemperature->expiresAfter(60 * 60);
        $this->cache->save($avgTemperature);

        return $data['main']['temp'];
    }
}
