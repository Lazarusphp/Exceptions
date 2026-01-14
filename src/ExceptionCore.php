<?php

namespace LazarusPhp\ExceptionHandler;

use RuntimeException;

class ExceptionCore extends RuntimeException
{
    protected int $statusCode = 500; // HTTP status code or error code

    public function __construct(string $message = '',int $code = 0,?\Throwable $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
