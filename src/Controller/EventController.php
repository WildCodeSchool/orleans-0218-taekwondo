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
use Model\Files;

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

    /**
     * Create a new event
     * @return string
     */
    public function adminEventCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['title']) || empty($_POST['date_event']) || empty($_POST['description']))
            header('Location: /admin/events');

        $data = [
            'title' => trim(strip_tags($_POST['title'])),
            'date_event' => $_POST['date_event'],
            'description' => trim(strip_tags($_POST['description'])),
            'picture' => null
        ];

        if ((!empty($_FILES['upload'])) && (!empty($_FILES['upload']['name']))) {
            // Create the upload folder
            if (!file_exists(BASE_ROOT . '/' . UPLOADS_PATH_EVENTS))
                mkdir(BASE_ROOT . '/' . UPLOADS_PATH_EVENTS);


            // Initiate the alerts manager & handle files from $_FILES
            $alertsManager = new Alerts\Manager();
            $filesHandler = new Files\Handler($_FILES['upload']);
            $file = $filesHandler->getFiles()[0];

            // 'Verifications'
            $isValidFile = $file->isValidFile(ALLOWED_TYPES);
            $isValidSize = $file->isValidSize(MAX_UPLOAD_SIZE);

            // Alerts if verifications have failed
            if (!$isValidFile || !$isValidSize) {
                if (!$isValidFile)
                    $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file type'));
                if (!$isValidSize)
                    $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file size'));
                header('Location: /admin/events');
                exit();
            }

            // Upload
            $data['picture'] = '/' . UPLOADS_PATH . '/events/' . uniqid() . '.' . $file->getType();
            $uploadSuccess = $file->upload(BASE_ROOT . '/' . $data['picture']);
            if (!$uploadSuccess) {
                $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage("Impossible d'upload l'image {$file->getName()}."));
                header('Location: /admin/events');
                exit();
            }
        }

        // Try to create the event
        $eventManager = new Event\Manager();
        $state = $eventManager->insert($data);

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
