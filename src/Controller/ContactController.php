<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 03/05/18
 * Time: 16:38
 */

namespace Controller;
use Model\Footer;


class ContactController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Contact/index.html.twig', ['links' => (new Footer\LinkManager())->getAll(),]);
    }
}