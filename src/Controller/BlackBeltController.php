<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 11:19
 */

namespace Controller;
use Model\AbstractManager;
use Model\BlackBelt;


class BlackBeltController extends AbstractController
{
    public function index(): string
    {
        $blackBeltManager = new BlackBelt\Manager();
        $blackBelts = $blackBeltManager->selectAllBlackBelt();
        return $this->twig->render('BlackBelt/index.html.twig', [
            'blackBeltsHonor' => array_splice($blackBelts, 0, 3),
            'blackBelts' => $blackBelts
        ]);
    }
}
