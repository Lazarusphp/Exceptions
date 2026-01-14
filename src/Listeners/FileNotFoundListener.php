<?php
namespace LazarusPhp\ExceptionHandler\Listeners;
use LazarusPhp\ExceptionHandler\Exceptions\FileNotFoundException;
use Throwable;

class FileNotFoundListener implements ExceptionListener
{
    public function support(Throwable $e):bool
    {
        return $e  instanceof FileNotFoundException;
    }

     public function handle(Throwable $e): void
    {
        if (!$e instanceof FileNotFoundException) {
            return;
        }

        http_response_code($e->getStatusCode());
        echo json_encode([
            'error' => 'File not found',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}