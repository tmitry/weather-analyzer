<?php

declare(strict_types=1);

namespace App\Temperature\Application\Message;

use Symfony\Component\Uid\Uuid;

readonly class CalculateAverageTemperatureMessage
{

    public function __construct(
        private Uuid $id
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}