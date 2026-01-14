<?php
namespace LazarusPhp\ExceptionHandler\Listeners;
use LazarusPhp\ExceptionHandler\Exceptions\FileNotFoundException;
use Throwable;

class FallbackExceptionListener implements ExceptionListener
{
    public function support(Throwable $e):bool
    {
        return true;
    }

    public function handle(Throwable $e): void
    {
        http_response_code(500);
        echo json_encode([
            'Fall Back error' => 'Internal server error',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}