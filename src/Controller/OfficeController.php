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
    /**
     * Display the office's staff
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(): string
    {
        $officeManager = new Office\Manager();

        return $this->twig->render('Office/index.html.twig', [
            'offices' => $officeManager->selectAllStaff(),
        ]);

    }

}