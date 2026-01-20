<?php
namespace LazarusPhp\Exceptions\Listeners;

use LazarusPhp\Exceptions\Exceptions\DirectoryNotFoundException;
use LazarusPhp\Logger\Level;
use LazarusPhp\Exceptions\Interfaces\ExceptionListenerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class DirectoryNotFoundListener implements ExceptionListenerInterface
{
    private LoggerInterface $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function support(Throwable $e):bool
    {
        return $e  instanceof DirectoryNotFoundException;
    }
    

     public function handle(Throwable $e): void
    {
        if (!$e instanceof DirectoryNotFoundException) {
            return;
        }

        $this->logger->warning($e->getMessage(),
        ["file"=>$e->getFile(),
        "Status Code"=>$e->getStatusCode(),
        "path"=>$e->getPath(),
        "ErrorCode" => $e->getCode(),
        "Level"=>Level::Warning->label(),
        ]);

        http_response_code($e->getStatusCode());
        echo json_encode([
            'error' => $e->getMessage(),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'level'=> Level::Warning->label(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}