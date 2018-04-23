<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 11/04/18
 * Time: 12:06
 */

namespace Model\Footer;


class Links
{
    private $id;
    private $web_address;
    private $open_in_other_window;
    private $link_title;
    private $text_of_link;

    private $size;

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTextOfLink()
    {
        return $this->text_of_link;
    }


    /**
     * @return string
     */
    public function getWebAddress()
    {
        return $this->web_address;
    }

    /**
     * @return bool
     */
    public function getOpenInOtherWindow()
    {
        return $this->open_in_other_window;
    }

    /**
     * @return string
     */
    public function getLinkTitle()
    {
        return $this->link_title;
    }

    

}