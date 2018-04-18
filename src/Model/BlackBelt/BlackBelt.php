<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 09:42
 */

namespace Model\BlackBelt;


class BlackBelt
{
    private $id;
    private $first_name;
    private $last_name;
    private $date_black_belt;
    private $picture;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */

    public function getDateBlackBelt(): string
    {
        return $this->date_black_belt;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getFullName(): string
    {
        $person = ucfirst($this->first_name) . ' ' . strtoupper($this->last_name);
        return $person;
    }

}

