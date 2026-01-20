<?php
namespace LazarusPhp\Exceptions\Listeners;
use LazarusPhp\Exceptions\Exceptions\FileNotFoundException;
use Throwable;
use Psr\Log\LoggerInterface;

class FileNotFoundListener implements ExceptionListener
{

    public function __construct(private LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
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