<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 26/04/18
 * Time: 11:43
 */

namespace Model\Office;


use Model\AbstractManager;

class Manager extends AbstractManager
{
    const TABLE = 'office';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

}