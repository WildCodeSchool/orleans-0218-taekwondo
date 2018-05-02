<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 27/04/18
 * Time: 00:56
 */

namespace Model\Office\Teacher;


class Teacher
{
    private $id;
    private $first_name;
    private $last_name;
    private $description;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

}