<?php
namespace Model\Album\Gallery;

use Model\AbstractManager;

class Manager extends AbstractManager {
    const TABLE = 'gallery';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Return the list of galleries
     * @return Instance[]
     */
    public function getAll(): array
    {
        $query = $this->pdoConnection
            ->query("SELECT * FROM {$this->table} ORDER BY id ASC", \PDO::FETCH_CLASS, Instance::class);
        return $query->fetchAll();
    }
}