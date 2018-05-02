<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 09:42
 */

namespace Model\Footer;
use Model\AbstractManager;

class Manager extends AbstractManager
{
    const TABLE = 'links';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Return an array of links
     * @return array
     */
    public function getAll(): array
    {
        return $this->pdoConnection
            ->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, Links::class)->fetchAll();
    }

    public function existsById(int $id): bool
    {
        $req = $this->pdoConnection->prepare("SELECT COUNT(*) AS nbr FROM $this->table WHERE id = :id");
        $req->bindValue('id', $id);
        $state = $req->execute();
        return $state ? $req->fetch(\PDO::FETCH_ASSOC)['nbr'] > 0 : false;
    }

}

