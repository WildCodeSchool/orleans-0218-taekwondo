<?php
/**
 * Created by PhpStorm.
 * User: wilder15
 * Date: 25/04/18
 * Time: 11:36
 */

namespace Controller;
use Model\Footer\sendMessage;


class FooterMessage
{
/*
    private $adressMail;
    private $message;

    public function getAdressMail(){
        $this->adressMail;
    }

    public function getMessage(){
        $this->message;
    }

*/

    private $_POST;

    public function get_POST(){
        $this->_POST;
    }


    public function __construct(array $_POST){


        if (!isset($_POST)){
            $sendTheMessage = new Model\Footer\sendMessage();
            return $this->sendTheMessage($_POST);
        }

        /*
        if (!isset($_POST)) {


            $adressMail = $_POST['courriel'];
            $message = $_POST['message'];
            }

        return $this->$adressMail;
        return $this->$message;
        // CA BUG


        */
    }





}