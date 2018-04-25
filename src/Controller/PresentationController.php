<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 24/04/18
 * Time: 14:34
 */

namespace Controller;
use Model\AbstractManager;


class PresentationController extends AbstractController
{
    public function index(): string
    {

        return $this->twig->render('Presentation/index.html.twig');
    }
}
