<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\Controller\Consumer;

use App\Temperature\Application\Command\CalculateAverageTemperature\CalculateAverageTemperatureCommandHandler;
use App\Temperature\Application\Message\CalculateAverageTemperatureMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CalculateAverageTemperatureMessageHandler
{
    public function __construct(
        private CalculateAverageTemperatureCommandHandler $calculateAverageTemperatureCommandHandler,
    ) {
    }

    public function __invoke(CalculateAverageTemperatureMessage $calculateAverageTemperatureMessage): void
    {
        $this->calculateAverageTemperatureCommandHandler->execute($calculateAverageTemperatureMessage->getId());
    }
}