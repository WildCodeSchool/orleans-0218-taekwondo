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
     * Create an office
     * @return string
     */
    public function adminOfficeCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['task'])) {
            header('Location: /admin/offices');
            exit;
        }

        $data = [
            'last_name' => strtoupper(trim(strip_tags($_POST['last_name']))),
            'first_name' => ucfirst(strtolower(trim(strip_tags($_POST['first_name'])))),
            'task' => ucfirst(strtolower(trim(strip_tags($_POST['task'])))),
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
                header('Location: /admin/offices');
                exit();
            }

            // Upload
            $data['picture'] = UPLOADS_PATH_OFFICES;
            $pictureName = uniqid() . '.' . $file->getType();
            $uploadSuccess = $file->upload(BASE_ROOT . $data['picture'], $pictureName);
            if (!$uploadSuccess) {
                $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage('Impossible d\'upload l\'image ' . $file->getName()));
                header('Location: /admin/offices');
                exit();
            }
            $data['picture'] .= $pictureName;
        }

        // Try to create the event
        $officeManager = new Office\Manager();
        $state = $officeManager->insert($data);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Bureau ajouté.');
        else $alert->setMessage('Impossible d\'ajouter le bureau.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);


        // Redirection
        header('Location: /admin/offices');
        exit();
    }
}