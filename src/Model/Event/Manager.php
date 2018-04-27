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

    /** Select events for the front-page (3max)
     * @return array
     */
    public function selectAllEventAsc(): array
    {
        return $this->pdoConnection
            ->query("SELECT * 
                                FROM $this->table 
                                WHERE date_event > DATE(NOW()) 
                                ORDER BY date_event ASC LIMIT 3" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }

    /**
     * Select past / future events thanks to a selector
     * @param int $filter
     * @return array
     */
    public function selectEventSelector(int $filter): array
    {
        $selector = '';

        if ($filter == 2) {
            $selector = 'WHERE date_event >= DATE(NOW()) ORDER BY date_event ASC';
        } elseif ($filter == 3) {
            $selector = 'WHERE date_event <= DATE(NOW()) ORDER BY date_event ASC';
        }

        return $this->pdoConnection
            ->query("SELECT * FROM $this->table $selector" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }

    /**
     * Select all events order by date
     * @return array
     */
    public function getAll(): array
    {
        return $this->pdoConnection
            ->query("SELECT * 
                                FROM $this->table 
                                ORDER BY date_event DESC" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }

}

