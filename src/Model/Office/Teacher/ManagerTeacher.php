<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 27/04/18
 * Time: 00:59
 */

namespace Model\Office\Teacher;
use Model\AbstractManager;

class ManagerTeacher extends AbstractManager
{
    const TABLE = 'teacher';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /** Select for the front-page (3max)
     * @return array
     */
    public function selectAllTeachers(): array
    {
        return $this->pdoConnection
            ->query("SELECT * FROM $this->table" , \PDO::FETCH_CLASS, Teacher::class)
            ->fetchAll();
    }
}