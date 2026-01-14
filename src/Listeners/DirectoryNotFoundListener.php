<?php
namespace LazarusPhp\ExceptionHandler\Listeners;

use LazarusPhp\ExceptionHandler\Exceptions\DirectoryNotFoundException;
use LazarusPhp\ExceptionHandler\Exceptions\FileNotFoundException;
use Throwable;

class DirectoryNotFoundListener implements ExceptionListener
{
    public function support(Throwable $e):bool
    {
        return $e  instanceof DirectoryNotFoundException;
    }

     public function handle(Throwable $e): void
    {
        if (!$e instanceof DirectoryNotFoundException) {
            return;
        }

        http_response_code($e->getStatusCode());
        echo json_encode([
            'error' => 'Directory Not found',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}