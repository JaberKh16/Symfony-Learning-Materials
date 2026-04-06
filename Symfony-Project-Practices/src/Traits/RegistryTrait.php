<?php

namespace App\Traits;

use Symfony\Bridge\Doctrine\ManagerRegistry;

trait RegistryTrait
{
    protected function getRegistry(): ManagerRegistry
    {
        return $this->container->get('doctrine');
    }
}