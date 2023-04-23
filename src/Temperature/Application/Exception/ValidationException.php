<?php

declare(strict_types=1);

namespace App\Temperature\Application\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends RuntimeException
{
    private ConstraintViolationListInterface $errors;

    public function __construct(
        ConstraintViolationListInterface $errors,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}