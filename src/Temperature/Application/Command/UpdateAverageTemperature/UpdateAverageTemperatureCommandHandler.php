<?php

declare(strict_types=1);

namespace App\Temperature\Application\Command\UpdateAverageTemperature;

use App\Temperature\Application\Exception\NotFoundException;
use App\Temperature\Application\Exception\ValidationException;
use App\Temperature\Application\Message\CalculateAverageTemperatureMessage;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdateAverageTemperatureCommandHandler
{
    public function __construct(
        private AverageTemperatureRepositoryInterface $averageTemperatureRepository,
        private ValidatorInterface $validator,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function execute(
        Uuid $id,
        UpdateAverageTemperatureCommand $updateAverageTemperatureCommand
    ): void {
        $violations = $this->validator->validate($updateAverageTemperatureCommand);
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }

        $averageTemperature = $this->averageTemperatureRepository->findOneById($id);

        if (!$averageTemperature) {
            throw new NotFoundException();
        }

        $averageTemperature->setCountry($updateAverageTemperatureCommand->getCountry());
        $averageTemperature->setCity($updateAverageTemperatureCommand->getCity());

        $this->averageTemperatureRepository->save($averageTemperature, true);

        $this->messageBus->dispatch(new CalculateAverageTemperatureMessage($id));
    }
}