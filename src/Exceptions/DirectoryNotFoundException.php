<?php
namespace LazarusPhp\Exceptions\Exceptions;
use LazarusPhp\Exceptions\CoreFiles\ExceptionCore;
use Psr\Log\LoggerInterface;
use Throwable;

class DirectoryNotFoundException extends ExceptionCore
{
    protected string $directory = "";

    // Directory Status Code 403
    protected int $statuscode = 403;
    
    public function __construct(string $directory)
    {
        $this->directory = $directory;
        parent::__construct("Directory not Found: {$directory}", $this->statuscode);
    }

    public function getPath(): string
    {
        return $this->directory;
    }
}