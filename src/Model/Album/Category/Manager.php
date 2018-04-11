<?php
namespace Model\Album\Category;

use Model\AbstractManager;

class Manager extends AbstractManager {
    const TABLE = 'category';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Return the list of categories
     * @return Instance[]
     */
    public function getAll(): array
    {
        $query = $this->pdoConnection
            ->query("SELECT * FROM {$this->table} ORDER BY id ASC", \PDO::FETCH_CLASS, Instance::class);
        return $query->fetchAll();
    }
}