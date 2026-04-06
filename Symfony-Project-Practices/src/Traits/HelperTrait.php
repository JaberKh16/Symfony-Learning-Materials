<?php

namespace App\Traits;

trait HelperTrait
{
    public function saveEntity($em, $entity)
    {
        $em->persist($entity);
        $em->flush();
    }
}