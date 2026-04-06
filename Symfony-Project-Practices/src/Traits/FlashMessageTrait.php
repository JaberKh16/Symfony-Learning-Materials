<?php

namespace App\Traits;

trait FlashMessageTrait
{
    public function successMessage($message)
    {
        $this->addFlash('success', $message);
    }

    public function errorMessage($message)
    {
        $this->addFlash('error', $message);
    }
}