<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 11/04/18
 * Time: 09:48
 */

namespace Model\Event;
use Model\AbstractManager;

class Manager extends AbstractManager
{
    const TABLE = 'event';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllEventAsc(): array
    {
        return $this->pdoConnection
            ->query("SELECT * 
                                FROM $this->table 
                                WHERE date_event > DATE(NOW()) 
                                ORDER BY date_event ASC LIMIT 3" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }


  public function selectEventSelector(int $filter): array
    {
        $selector = '';

        if ($filter == 2) {
            $selector = 'WHERE date_event > DATE(NOW()) ORDER BY date_event ASC';
        } elseif ($filter == 3) {
            $selector = 'WHERE date_event < DATE(NOW()) ORDER BY date_event ASC';
        }

        return $this->pdoConnection
            ->query("SELECT * FROM $this->table $selector" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();

    }

}
