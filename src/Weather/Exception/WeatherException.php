<?php
declare(strict_types=1);

namespace App\Weather\Exception;

use Exception;
use Throwable;

class WeatherException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}