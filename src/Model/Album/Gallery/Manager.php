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
    public function getAll(int $categoryId, string $searchGallery): array
    {
        $where = [];
        if ($categoryId > 0) $where[] = 'category_id = ' . $categoryId;
        if (!empty($searchGallery)) $where[] = "title LIKE '%{$searchGallery}%'";
        $finalClause = count($where) > 0 ? ' WHERE ' . implode(' AND ', $where) : '';

        $query = $this->pdoConnection
            ->query("SELECT * FROM {$this->table}{$finalClause} ORDER BY id ASC", \PDO::FETCH_CLASS, Instance::class);
        return $query->fetchAll();
    }
}