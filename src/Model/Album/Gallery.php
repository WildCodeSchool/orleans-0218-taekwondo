<?php
namespace Model\Album;

class Gallery {
    private $id;
    private $category_id;
    private $title;
    private $description;

    public function getId(): int { return $this->id; }
    public function getCategoryId(): int { return $this->category_id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }

    public function getImages(): array
    {
        $manager = new Manager\Image();
        return $manager->getByGalleryId($this->getId());
    }
}