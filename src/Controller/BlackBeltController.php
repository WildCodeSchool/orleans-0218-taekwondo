<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 18/04/18
 * Time: 11:19
 */

namespace Controller;
use Model\BlackBelt\Manager;
use Model\Files;
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

    /**
     *
     * @return string
     */
    public function adminBlackBeltCreate()
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['number_dan']) || empty($_POST['date_dan'])) {
            header('Location: /admin/black-belts');
            exit();
        }


        $data = [
            'first_name' => trim(strip_tags($_POST['first_name'])),
            'last_name' => trim(strip_tags($_POST['last_name'])),
            'number_dan' => (int)trim(strip_tags($_POST['number_dan'])),
            'date_dan' =>(int)trim($_POST['date_dan']) ,
            'picture' => null
        ];


        if ((!empty($_FILES['upload'])) && (!empty($_FILES['upload']['name']))) {
            // Initiate the alerts manager & handle files from $_FILES
            $alertsManager = new Alerts\Manager();
            $filesHandler = new Files\Handler($_FILES['upload']);
            $file = $filesHandler->getFiles()[0];

            // 'Verifications'
            $isValidFile = $file->isValidFile(ALLOWED_TYPES);
            $isValidSize = $file->isValidSize(MAX_UPLOAD_SIZE);

            // Alerts if verifications have failed
            if (!$isValidFile || !$isValidSize) {
                if (!$isValidFile) {
                    $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file type'));
                }
                if (!$isValidSize) {
                    $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file size'));
                    header('Location: /admin/black-belts');
                    exit();
                }
            }

            // Upload
            $data['picture'] = '/' . UPLOADS_PATH . '/black-belts/';
            $pictureName = uniqid() . '.' . $file->getType();
            $uploadSuccess = $file->upload(BASE_ROOT . $data['picture'], $pictureName);
            if (!$uploadSuccess) {
                $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage("Impossible d'upload l'image " . $file->getName() . "."));
                header('Location: /admin/black-belts');
                exit();
            }
            $data['picture'] .= $pictureName;
        }

        // Try to create the black belt
        $blackBeltManager = new BlackBelt\Manager();
        $state = $blackBeltManager->insert($data);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Ceinture noire ajoutée.');
        } else {
            $alert->setMessage('Impossible d\'ajouter la ceinture noire.');
        }

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/black-belts');
        exit();
    }

    /**
     * @param int $id
     * @return null|string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminBlackBeltUpdate(int $id): ?string
    {

        if ((isset($_POST)) && (!empty($_POST['last_name']))){
            $blackBeltManager = new BlackBelt\Manager();
            if (!$blackBeltManager->existsById($id)) {
                return null;
            }

            $data = [
                'first_name' => trim(strip_tags($_POST['first_name'])),
                'last_name' => trim(strip_tags($_POST['last_name'])),
                'number_dan' => (int)trim(strip_tags($_POST['number_dan'])),
                'date_dan' => (int)trim($_POST['date_dan']),
                'picture' => null
            ];

            if ((!empty($_FILES['upload'])) && (!empty($_FILES['upload']['name']))) {

                // Initiate the alerts manager & handle files from $_FILES
                $alertsManager = new Alerts\Manager();
                $filesHandler = new Files\Handler($_FILES['upload']);
                $file = $filesHandler->getFiles()[0];

                // 'Verifications'
                $isValidFile = $file->isValidFile(ALLOWED_TYPES);
                $isValidSize = $file->isValidSize(MAX_UPLOAD_SIZE);

                // Alerts if verifications have failed
                if (!$isValidFile || !$isValidSize) {
                    if (!$isValidFile) {
                        $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file type'));
                    }
                    if (!$isValidSize) {
                        $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Invalid file size'));
                    }
                    header('Location: /admin/black-belts');
                    exit();
                }

                // Upload
                $data['picture'] = UPLOADS_PATH_OFFICES;
                $pictureName = uniqid() . '.' . $file->getType();
                $uploadSuccess = $file->upload(BASE_ROOT . $data['picture'], $pictureName);
                if (!$uploadSuccess) {
                    $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage("Impossible d'upload l'image " . $file->getName() . "."));
                    header('Location: /admin/black-belts');
                    exit();
                }
                $data['picture'] .= $pictureName;
            } else {
                unset($data['picture']);
            }


            $state = $blackBeltManager->update($id, $data);

            $alert = new Alerts\Alert();
            $alert->setState($state);
            if ($alert->getState()) {
                $alert->setMessage('La ceinture a été mise à jour.');
            } else {
                $alert->setMessage('Impossible de mettre à jour la ceinture.');
            }

            $alertsManager = new Alerts\Manager();
            $alertsManager->addAlert($alert);

            header("Location: /admin/black-belts");
            exit();

        } else {

            $blackBeltManager = new BlackBelt\Manager();
            if (!$blackBeltManager->existsById($id)) {
                return null;
            }

            $alertsManager = new Alerts\Manager();
            $alerts = $alertsManager->getAlerts();
            $alertsManager->clean();

            return $this->twig->render('BlackBelt/Admin/Update/index.html.twig', [
                'blackBelt' => $blackBeltManager->selectOneById($id),
                'alerts' => $alerts
            ]);
        }
    }
}
