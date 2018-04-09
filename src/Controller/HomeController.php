<?php
/**
 * Created by PhpStorm.
 * User: sapuraizu
 * Date: 28/03/18
 * Time: 11:01
 */

namespace Controller;

class HomeController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }
}