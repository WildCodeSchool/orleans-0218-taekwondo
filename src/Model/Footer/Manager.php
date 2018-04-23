<?php
/**
 * Created by PhpStorm.
 * User: wilder15
 * Date: 18/04/18
 * Time: 11:35
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


    public function getAll(): array
    {
        return $this->pdoConnection
            ->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, Links::class)->fetchAll();
    }


}


