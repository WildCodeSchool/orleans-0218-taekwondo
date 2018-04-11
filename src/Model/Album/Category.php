<?php
namespace Model\Album;

class Category {
    private $id;
    private $name;

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
}