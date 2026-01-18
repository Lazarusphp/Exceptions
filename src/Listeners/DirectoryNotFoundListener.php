<?php
namespace LazarusPhp\ExceptionHandler\Listeners;

use LazarusPhp\ExceptionHandler\Exceptions\DirectoryNotFoundException;
use LazarusPhp\ExceptionHandler\Exceptions\FileNotFoundException;
use Psr\Log\LoggerInterface;
use Throwable;

class DirectoryNotFoundListener implements ExceptionListener
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

        $this->logger->warning("Directory Not Found",
        ["file"=>$e->getFile(),
        "Status Code"=>$e->getStatusCode(),
        "path"=>$e->getPath(),
        "User"=>$e->getCode()
        ]);
        $user = "Martin";
        $this->logger->error("User Accessed Restricted Drive {$user}");

        http_response_code($e->getStatusCode());
        echo json_encode([
            'error' => 'Directory Not found',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}