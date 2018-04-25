<?php
/**
 * Created by PhpStorm.
 * User: wilder15
 * Date: 25/04/18
 * Time: 11:28
 */

namespace Model\Footer;


class sendMessage
{


    // récupérer les données du formulaire

    // renvoyer les données du formulaire

    public function __construct(array $message){

        var_dump($message['courriel']);
        var_dump($message['message']);

    }
}