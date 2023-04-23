<?php

declare(strict_types=1);

namespace App\Temperature\Application\Query\GetAverageTemperatures;

use App\Temperature\Domain\Entity\AverageTemperature;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;

readonly class GetAverageTemperaturesQueryHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository,
    ) {
    }

    /**
     * @return array<int, AverageTemperature>
     */
    public function execute(): array
    {
        return $this->averageTemperatureRepository->findAllByCriteria();
    }
}