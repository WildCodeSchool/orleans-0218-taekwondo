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

    /**
     * Return an array of black belts
     * @return BlackBelt[]
     */
    public function selectAllBlackBelt(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table ORDER BY number_dan DESC, last_name ASC" , \PDO::FETCH_CLASS, BlackBelt::class)
            ->fetchAll();
    }

    /**
     * Return an array of dan
     * @return array
     */
    public function getSortByDan(): array
    {
        $elements= $this->selectAllBlackBelt();

        $sortByDans= [];

        foreach ($elements as $element) {
            if (!isset($sortByDans[$element->getNumberDan()])) {
                $sortByDans[$element->getNumberDan()] = [];
            }

            $sortByDans[$element->getNumberDan()][] = $element;
        }

        return $sortByDans;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->pdoConnection
            ->query("SELECT * 
                                FROM $this->table 
                                ORDER BY last_name ASC" , \PDO::FETCH_CLASS, BlackBelt::class)
            ->fetchAll();
    }


}

