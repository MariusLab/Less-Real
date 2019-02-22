<?php

namespace App\Entity;

class PrimaryTagImage extends AbstractEntity
{
    private $id;
    private $isCropped;
    private $image;
    private $tag;

    public function getId(): int
    {
        return $this->id;
    }

    public function isCropped(): int
    {
        return $this->isCropped;
    }

    public function setCropped(bool $isCropped): PrimaryTagImage
    {
        $this->isCropped = $isCropped;
        return $this;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getTag(): PrimaryTag
    {
        return $this->tag;
    }
}
