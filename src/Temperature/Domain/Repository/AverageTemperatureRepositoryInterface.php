<?php

namespace App\Temperature\Domain\Repository;

use App\Temperature\Domain\Entity\AverageTemperature;
use Symfony\Component\Uid\Uuid;

interface AverageTemperatureRepositoryInterface
{
    /**
     * @return array<int, AverageTemperature>
     */
    public function findAllByCriteria(): array;

    public function findOneById(Uuid $id): ?AverageTemperature;

    public function save(AverageTemperature $entity, bool $flush = false): void;

    public function remove(AverageTemperature $entity, bool $flush = false): void;
}