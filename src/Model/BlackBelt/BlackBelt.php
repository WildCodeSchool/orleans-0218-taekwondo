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
    private $date_dan;
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
        return mb_strtoupper(mb_substr( $this->first_name, 0, 1 )).mb_substr($this->first_name, 1 );
    }


    /**
     * @return string
     */
    public function getLastName(): string
    {
        return strtoupper($this->last_name);
    }

    /**
     * @return int
     */

    public function getDateDan(): int
    {
        return $this->date_dan;
    }

    /**
     * @return string
     */
    public function getPicture()
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

