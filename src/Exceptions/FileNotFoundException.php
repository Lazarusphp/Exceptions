<?php
namespace LazarusPhp\Exceptions\Exceptions;
use LazarusPhp\Exceptions\ExceptionCore;
use Throwable;

class FileNotFoundException extends ExceptionCore
{
    protected string $path = "";

    // File Not Found 404
    protected int $statuscode = 404;

    public function __construct(string $path)
    {
        $this->path = $path;
        parent::__construct("File not found: {$path}",$this->statuscode);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}