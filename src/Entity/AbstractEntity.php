<?php

namespace App\Entity;

abstract class AbstractEntity
{
    protected $createdAt;
    protected $updatedAt;

    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
