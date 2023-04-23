<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\DeleteAverageTemperature;

use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class DeleteAverageTemperatureCommandHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository
    ) {
    }

    public function execute(Uuid $id): void
    {
        $averageTemperature = $this->averageTemperatureRepository->findOneById($id);

        if (!$averageTemperature) {
            throw new NotFoundException();
        }

        $this->averageTemperatureRepository->remove($averageTemperature, true);
    }
}