<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 26/04/18
 * Time: 11:43
 */

namespace Model\Office;
use Model\AbstractManager;

class Manager extends AbstractManager
{
    const TABLE = 'office';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /** Select for the front-page (3max)
     * @return array
     */
    public function selectAllStaff(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table" , \PDO::FETCH_CLASS, Office::class)
            ->fetchAll();
    }
}