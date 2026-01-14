<?php
namespace LazarusPhp\ExceptionHandler\Listeners;

use Throwable;

interface ExceptionListener
{
    public function support(Throwable $e):bool;
    public function handle(Throwable $e):void;
}