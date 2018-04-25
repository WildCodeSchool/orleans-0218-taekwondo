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
            'blackBelts' => $blackBeltManager->getAll(),
            'alerts' => $alerts
        ]);
    }


    /**
     * @param int $id
     * @return string
     */
    public function adminBlackBeltDelete(int $id): string
    {
        // Verifications
        if ($id <= 0) header('Location: /admin/black-belts');

        // Try to delete the event
        $blackBeltManager = new BlackBelt\Manager();
        if (!$blackBeltManager->existsById($id)) header('Location: /admin/black-belts');
        $state = $blackBeltManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('La ceinture noire a été supprimée.');
        else $alert->setMessage('Impossible de supprimer la ceinture noire');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/black-belts');
        exit();
    }
}

