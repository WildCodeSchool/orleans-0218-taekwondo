<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 26/04/18
 * Time: 11:47
 */

namespace Controller;
use Model\Office;
use Model\Session\Alerts;
use Model\Files;

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

        $officeManager = new Office\Manager();
        return $this->twig->render('Office/Admin/index.html.twig', [
            'officesAdmin' => $officeManager->selectAllStaff(),
            'alerts' => $alerts
        ]);
    }

    /**
     * delete an office
     * @param int $id
     * @return string
     */
    public function adminOfficeDelete(int $id): string
    {
        // Verifications
        if ($id <= 0) {
            header('Location: /admin/offices');
        }

        // Try to delete the event
        $officeManager = new Office\Manager();
        if (!$officeManager->existsById($id)) {
            header('Location: /admin/offices');
        }
        $state = $officeManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Le bureau a été supprimé.');
        }
        else $alert->setMessage('Impossible de supprimer le bureau');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/offices');
        exit();
    }

}