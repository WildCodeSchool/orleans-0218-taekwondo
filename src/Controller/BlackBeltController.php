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
use Model\Session\Alerts;

class BlackBeltController extends AbstractController
{

    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(): string
    {
        $blackBeltManager = new BlackBelt\Manager();

        return $this->twig->render('BlackBelt/index.html.twig', [
            'dans' => $blackBeltManager->getSortByDan()
        ]);
    }

    /**
     * (admin) Show all the black belts
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminIndex(): string
    {
        // Retrieve alerts
        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        $blackBeltManager = new BlackBelt\Manager();
        return $this->twig->render('BlackBelt/Admin/index.html.twig', [
            'blackBeltsAdmin' => $blackBeltManager->getAll(),
            'alerts' => $alerts
        ]);
    }
}

