<?php

declare(strict_types=1);

namespace App\Temperature\Application\Query\GetAverageTemperature;

use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Domain\Entity\AverageTemperature;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class GetAverageTemperatureQueryHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository
    ) {
    }

    public function execute(Uuid $id): AverageTemperature
    {
        $averageTemperature = $this->averageTemperatureRepository->findOneById($id);

        if (!$averageTemperature) {
            throw new NotFoundException();
        }

        return $averageTemperature;
    }
}