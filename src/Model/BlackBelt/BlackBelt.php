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
        return ucfirst($this->first_name);
    }

    /**
     * @return mixed
     */
    public function getLastName(): string
    {
        return strtoupper($this->last_name);
    }

    /**
     * @return mixed
     */

    public function getDateDanBlackBelt(): string
    {
        return $this->date_dan_black_belt;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return mixed
     */
    public function getNumberDan(): int
    {
        return $this->number_dan;
    }

}

