<?php

namespace App\Entity;

class Quote extends AbstractEntity
{
    const STATUS_DELETED = 'deleted';
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';

    private $id;
    private $status;
    private $author;
    private $series;
    private $body;
    private $username;
    private $oldCreatedAt;

    public function getFullPathToFaceImage(): string
    {
        $tagImage = $this->author->getTagImage();
        $imagePath = explode("/", $tagImage->getImage()->getFull());
        $imageName = $imagePath[sizeof($imagePath) - 1];

        if ($tagImage->isCropped()) {
            return '/imagevault/uploaded/quotefaces/'.$imageName;
        } else {
            $image = $tagImage->getImage();
            $partition = ceil($image->getId()/5000);
            return '/imagevault/uploaded/imagessolidthumbnails/part'.$partition.'/'.$imageName;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Quote
    {
        $this->status = $status;
        return $this;
    }

    public function getAuthor(): PrimaryTag
    {
        return $this->author;
    }

    public function getSeries(): PrimaryTag
    {
        return $this->series;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): Quote
    {
        $this->body = $body;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Quote
    {
        $this->username = $username;
        return $this;
    }

    public function getOldCreatedAt(): int
    {
        return $this->oldCreatedAt;
    }

    public function setOldCreatedAt(int $oldCreatedAt): Quote
    {
        $this->oldCreatedAt = $oldCreatedAt;
        return $this;
    }
}
