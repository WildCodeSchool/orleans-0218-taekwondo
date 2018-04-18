<?php
namespace Model\Album\Manager;

use Model\AbstractManager;
use Model\Album;

class Category extends AbstractManager {
    const TABLE = 'category';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Return the list of categories
     * @return Album\Category[]
     */
    public function getAll(): array
    {
        $query = $this->pdoConnection
            ->query("SELECT * FROM $this->table ORDER BY id ASC", \PDO::FETCH_CLASS, Album\Category::class);
        return $query->fetchAll();
    }

    public function create(string $name): bool
    {
        return $this->insert([
            'name' => $name
        ]);
    }
}