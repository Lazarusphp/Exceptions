<?php
namespace LazarusPhp\Exceptions\Listeners;
use LazarusPhp\Exceptions\Exceptions\FileNotFoundException;
use Throwable;
use Psr\Log\LoggerInterface;

class FallbackExceptionListener implements ExceptionListener
{
    private LoggerInterface $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
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