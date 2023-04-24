<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\CalculateAverageTemperature;

use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class CalculateAverageTemperatureCommandHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository,
        /** @var iterable<TemperatureProviderInterface> */
        private iterable $temperatureProviders
    ) {
    }

    public function execute(Uuid $id): void
    {
        $averageTemperature = $this->averageTemperatureRepository->findOneById($id);

        if (!$averageTemperature) {
            throw new NotFoundException();
        }

        $count = count($this->temperatureProviders);
        $sum = 0;
        foreach ($this->temperatureProviders as $temperatureProvider) {
            $temperatureDto = $temperatureProvider->getTemperature(
                $averageTemperature->getLocation()->getCountry(),
                $averageTemperature->getLocation()->getCity(),
            );

            $sum += $temperatureDto->getTemperature();
        }

        $avg = $count === 0 ? 0 : round($sum / $count, 2);

        $averageTemperature->setAvgTemperature((string) $avg);

        $this->averageTemperatureRepository->save($averageTemperature, true);
    }
}