<?php
namespace LazarusPhp\Exceptions\Listeners;
use LazarusPhp\Exceptions\Interfaces\ExceptionListenerInterface;
use LazarusPhp\Logger\Level;
use Throwable;
use Psr\Log\LoggerInterface;

class FallbackExceptionListener implements ExceptionListenerInterface
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

        $this->logger->error("FallBack Exception",
        [
            "Level"=>Level::Error->Label(),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ]);

        http_response_code(500);
        echo json_encode([
            'Fall Back Exception' => 'Internal server error',
            'message' => $e->getMessage(),
            'Level'=>Level::Error,
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}