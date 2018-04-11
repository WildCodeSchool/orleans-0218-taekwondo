<?php
namespace Model\Album\Image;

class Instance {
    private $id;
    private $gallery_id;
    private $url;

    public function getId(): int { return $this->id; }
    public function getGalleryId(): int { return $this->gallery_id; }
    public function getUrl(): string { return $this->url; }
}