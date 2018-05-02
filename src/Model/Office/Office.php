<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 26/04/18
 * Time: 11:43
 */

namespace Model\Office;


class Office
{
    private $id;
    private $first_name;
    private $last_name;
    private $task;
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
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @return mixed string or null
     */
    public function getPicture()
    {
        return $this->picture;
    }

}