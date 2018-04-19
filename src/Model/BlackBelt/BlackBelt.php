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
    private $date_dan_black_belt;
    private $picture;
    private $number_dan;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return ucfirst($this->first_name);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return strtoupper($this->last_name);
    }

    /**
     * @return string
     */

    public function getDateDanBlackBelt(): string
    {
        return $this->date_dan_black_belt;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @return int
     */
    public function getNumberDan(): int
    {
        return $this->number_dan;
    }

}

