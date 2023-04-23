<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\CreateAverageTemperature;

use App\Temperature\Application\Exception\ValidationException;
use App\Temperature\Application\Message\CalculateAverageTemperatureMessage;
use App\Temperature\Domain\Entity\AverageTemperature;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateAverageTemperatureCommandHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository,
        private ValidatorInterface $validator,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function execute(
        CreateAverageTemperatureCommand $createAverageTemperatureCommand
    ): void {
        $violations = $this->validator->validate($createAverageTemperatureCommand);
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }

        $id = $this->generateId();

        $averageTemperature = new AverageTemperature(
            $id,
            $createAverageTemperatureCommand->getCountry(),
            $createAverageTemperatureCommand->getCity(),
            null
        );

        $this->averageTemperatureRepository->save($averageTemperature, true);

        $this->messageBus->dispatch(new CalculateAverageTemperatureMessage($id));
    }

    private function generateId(): Uuid
    {
        return Uuid::v7();
    }
}