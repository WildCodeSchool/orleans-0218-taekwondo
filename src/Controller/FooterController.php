<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 11:19
 */

namespace Controller;
use Model\Footer\Manager;
use Model\Footer;
use Model\Session\Alerts;



class FooterController extends AbstractController
{


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

        $footerManager = new Footer\Manager();
        return $this->twig->render('Footer/Admin/index.html.twig', [
            'links' => $footerManager->getAll(),
            'alerts' => $alerts
        ]);
    }


    /**
     *
     * @return string
     */
    public function adminFooterCreate()
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['name']) || empty($_POST['address']) ) {
            header('Location: /admin/footer');
            exit();
        }


        // Je vérifie qu'il s'agisse bien d'une adresse valide
        if (!filter_var($_POST['address'], FILTER_VALIDATE_URL)){
            header('Location: /admin/footer');
            exit();
        }

        $data = [
            'text_of_link' => trim(strip_tags($_POST['name'])),
            'web_address' => trim(strip_tags($_POST['address'])),
            'link_title' => trim($_POST['comment']) ,
        ];


        // Try to create the footer
        $footerManager = new Footer\Manager();
        $state = $footerManager->insert($data);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Lien ajoutée.');
        } else {
            $alert->setMessage('Impossible d\'ajouter le lien.');
        }

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/footer');
        exit();
    }


    /**
     * @param int $id
     * @return string
     */
    public function adminFooterDelete(int $id): string
    {
        // Verifications
        if ($id <= 0) header('Location: /admin/footer');

        // Try to delete an item
        $footerManager = new Footer\Manager();
        if (!$footerManager->existsById($id)) header('Location: /admin/footer');
        $state = $footerManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Le lien a été supprimée.');
        else $alert->setMessage('Impossible de supprimer le lien');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/footer');
        exit();
    }


}
