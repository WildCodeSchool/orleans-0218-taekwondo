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
            ->query("SELECT * FROM $this->table WHERE date_event > DATE(NOW()) ORDER BY date_event ASC LIMIT 3" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }

    public function selectAllEvent(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table ORDER BY date_event ASC" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();


    }

    public function selectEventSelectorFutur(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table WHERE date_event > DATE(NOW()) ORDER BY date_event ASC" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }

    public function selectEventSelectorPast(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table WHERE date_event < DATE(NOW()) ORDER BY date_event ASC" , \PDO::FETCH_CLASS, Event::class)
            ->fetchAll();
    }
}
