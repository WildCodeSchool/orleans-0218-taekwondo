<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 09:42
 */

namespace Model\BlackBelt;
use Model\AbstractManager;

class Manager extends AbstractManager
{
    const TABLE = 'black_belt';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllBlackBelt(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table ORDER BY date_black_belt DESC" , \PDO::FETCH_CLASS, BlackBelt::class)
            ->fetchAll();
    }
}
