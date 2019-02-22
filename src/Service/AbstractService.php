<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{
    protected $entityManager;

    protected function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}
