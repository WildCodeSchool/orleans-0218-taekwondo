<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 11/04/18
 * Time: 17:10
 */

namespace Controller;
use Model\Event;
use Model\Session\Alerts;

class EventController extends AbstractController
{
    /**
     * (client) show specific events thanks to a selector
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(): string
    {
        $filter = isset($_GET['filterId']) ? (int)$_GET['filterId'] : 0;
        $eventManager = new Event\Manager();

        return $this->twig->render('Event/index.html.twig', [
            'events' => $eventManager->selectEventSelector($filter),
            'filter' => $filter,
        ]);
    }

    /**
     * (admin) Show all the events
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

        $eventManager = new Event\Manager();
        return $this->twig->render('Event/Admin/index.html.twig', [
            'eventsAdmin' => $eventManager->getAll(),
            'alerts' => $alerts
        ]);
    }

    /**
     * (Admin)[Form] Delete a event
     * @param int $id
     * @return string
     */
    public function adminEventDelete(int $id): string
    {
        // Verifications
        if ($id <= 0) header('Location: /admin/events');

        // Try to delete the event
        $eventManager = new Event\Manager();
        if (!$eventManager->existsById($id)) header('Location: /admin/events');
        $state = $eventManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('L\'événement a été supprimée.');
        else $alert->setMessage('Impossible de supprimer l\'événement');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/events');
        exit();
    }

    /**Create a new event
     * @return string
     */
    public function adminEventCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['title']) || empty($_POST['date_event']) || empty($_POST['description'])) header('Location: /admin/events');

        $title = trim(strip_tags($_POST['title']));
        $dateEvent = (string)$_POST['date_event'];
        $description = trim(strip_tags($_POST['description']));

        var_dump($_POST);

        // Try to create the event
        $galleriesManager = new Event\Manager();
        $state = $galleriesManager->insert([
            'title' => $title,
            'date_event' => $dateEvent,
            'description' => $description,
        ]);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Evénement ajouté.');
        else $alert->setMessage('Impossible d\'ajouter l\'événement.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/events');
        exit();
    }
}