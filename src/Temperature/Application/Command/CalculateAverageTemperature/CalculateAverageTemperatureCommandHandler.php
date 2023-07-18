<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\CalculateAverageTemperature;

use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use App\Temperature\Domain\TemperatureProviderInterface;
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

        $averageTemperature->updateAvgTemperature($this->temperatureProviders);

        $this->averageTemperatureRepository->save($averageTemperature, true);
    }
}