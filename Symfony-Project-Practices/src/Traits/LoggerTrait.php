<?php

namespace App\Traits;

trait LoggerTrait
{
    public function logMessage(string $message): void
    {
        dump("Log: " . $message);
    }
}