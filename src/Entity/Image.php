<?php

namespace App\Entity;

class Image extends AbstractEntity
{
    private $id;
    private $full;
    private $thumbnail;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFull(): string
    {
        return $this->full;
    }

    public function setFull(string $full): Image
    {
        $this->full = $full;
        return $this;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): Image
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }
}
