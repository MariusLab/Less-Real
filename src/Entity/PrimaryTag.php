<?php

namespace App\Entity;

class PrimaryTag extends AbstractEntity
{
    private $id;
    private $tagImage;
    private $type;
    private $label;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTagImage(): PrimaryTagImage
    {
        return $this->tagImage;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): PrimaryTag
    {
        $this->type = $type;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): PrimaryTag
    {
        $this->label = $label;
        return $this;
    }
}
