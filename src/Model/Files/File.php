<?php
namespace Model\Files;

class File {
    private $name;
    private $mime;
    private $tmp_name;
    private $error;
    private $size;
    private $type;

    public function __construct(string $name, string $mime, string $tmp_name, int $error, int $size)
    {
        $this->name = $name;
        $this->mime = $mime;
        $this->tmp_name = $tmp_name;
        $this->error = $error;
        $this->size = $size;
        $this->type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    }

    public function getName(): string { return $this->name; }
    public function getMime(): string { return $this->mime; }
    public function getTmpName(): string { return $this->tmp_name; }
    public function getError(): int { return $this->error; }
    public function getSize(): int { return $this->size; }
    public function getType(): string { return $this->type; }

    public function isValidFile(array $allowedTypes): bool { return in_array($this->getType(), $allowedTypes); }
    public function isValidSize(int $maxSize): bool { return $this->getSize() <= $maxSize; }

    public function upload(string $path): bool { return move_uploaded_file($this->getTmpName(), $path); }
}
