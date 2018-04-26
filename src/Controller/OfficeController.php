<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 26/04/18
 * Time: 11:47
 */

namespace Controller;
use Model\Office;

class OfficeController extends AbstractController
{
    public function index(): string
    {
        $officeManager = new Office\Manager();

        return $this->twig->render('Office/index.html.twig', [
            'office' => $officeManager->selectAll(),
        ]);
    }

}