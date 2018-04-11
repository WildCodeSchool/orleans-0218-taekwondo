<?php
namespace Model\Album\Category;

class Instance {
    private $id;
    private $name;

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
}