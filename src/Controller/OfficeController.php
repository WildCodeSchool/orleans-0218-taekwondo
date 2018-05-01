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
        $teacherManager = new Office\Teacher\ManagerTeacher();

        return $this->twig->render('Office/index.html.twig', [
            'offices' => $officeManager->selectAllStaff(),
            'profs' => $teacherManager->selectAllTeachers(),
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
        return $this->twig->render('Office/Admin/Staff/index.html.twig', [
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
            exit;
        }

        // Try to delete the event
        $officeManager = new Office\Manager();
        if (!$officeManager->existsById($id)) {
            header('Location: /admin/offices');
            exit;
        }
        $state = $officeManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Le bureau a été supprimé.');
        } else $alert->setMessage('Impossible de supprimer le bureau');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/offices');
        exit();
    }

    /**
     * Update an office
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminOfficeUpdateIndex(int $id): string
    {
        $officeManager = new Office\Manager();
        if (!$officeManager->existsById($id)) {
            return '';
        }

        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        return $this->twig->render('Office/Admin/Update/index.html.twig', [
            'office' => $officeManager->selectOneById($id),
            'alerts' => $alerts
        ]);
    }

    public function adminOfficeUpdate(int $id)
    {
        $officeManager = new Office\Manager();
        if (!$officeManager->existsById($id)) {
            return '';
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
                $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage("Impossible d'upload l'image " . $file->getName() . "."));
                header('Location: /admin/offices');
                exit();
            }
            $data['picture'] .= $pictureName;
        } else {
            unset($data['picture']);
        }


        $state = $officeManager->update($id, $data);

        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Le bureau a été mise à jour.');
        } else {
            $alert->setMessage('Impossible de mettre à jour le bureau.');
        }

        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        header("Location: /admin/offices");
        exit();
    }

    /** Listing of the teachers
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminTeacherIndex(): string
    {
        // Retrieve alerts
        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        $teacherManager = new Office\Teacher\ManagerTeacher();
        return $this->twig->render('Office/Admin/Teacher/index.html.twig', [
            'teachersAdmin' => $teacherManager->selectAllTeachers(),
            'alerts' => $alerts
        ]);
    }

    /** Create a new teacher
     * Create an office
     * @return string
     */
    public function adminTeacherCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['description'])) {
            header('Location: /admin/teachers');
            exit;
        }

        $data = [
            'last_name' => strtoupper(trim(strip_tags($_POST['last_name']))),
            'first_name' => ucfirst(strtolower(trim(strip_tags($_POST['first_name'])))),
            'description' => ucfirst(strtolower(trim(strip_tags($_POST['description'])))),
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
                header('Location: /admin/teachers');
                exit();
            }
            $data['picture'] .= $pictureName;
        }

        // Try to create the event
        $teacherManager = new Office\Teacher\ManagerTeacher();
        $state = $teacherManager->insert($data);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Bureau ajouté.');
        else $alert->setMessage('Impossible d\'ajouter le bureau.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);


        // Redirection
        header('Location: /admin/teachers');
        exit();
    }

    /**
     * delete an office
     * @param int $id
     * @return string
     */
    public function adminTeacherDelete(int $id): string
    {
        // Verifications
        if ($id <= 0) {
            header('Location: /admin/teachers');
            exit;
        }

        // Try to delete the event
        $teacherManager = new Office\Teacher\ManagerTeacher();
        if (!$teacherManager->existsById($id)) {
            header('Location: /admin/teachers');
            exit;
        }
        $state = $teacherManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Le bureau a été supprimé.');
        } else $alert->setMessage('Impossible de supprimer le bureau');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/teachers');
        exit();
    }

    /**
     * Update an office
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminTeacherUpdateIndex(int $id): string
    {
        $teacherManager = new Office\Teacher\ManagerTeacher();
        if (!$teacherManager->existsById($id)) {
            return '';
        }

        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        return $this->twig->render('Office/Admin/Teacher/Update/index.html.twig', [
            'teacher' => $teacherManager->selectOneById($id),
            'alerts' => $alerts
        ]);
    }

    public function adminTeacherUpdate(int $id)
    {
        $teacherManager = new Office\Teacher\ManagerTeacher();
        if (!$teacherManager->existsById($id)) {
            return '';
        }

        $data = [
            'last_name' => strtoupper(trim(strip_tags($_POST['last_name']))),
            'first_name' => ucfirst(strtolower(trim(strip_tags($_POST['first_name'])))),
            'description' => ucfirst(strtolower(trim(strip_tags($_POST['description'])))),
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
                header('Location: /admin/teachers');
                exit();
            }

            // Upload
            $data['picture'] = UPLOADS_PATH_OFFICES;
            $pictureName = uniqid() . '.' . $file->getType();
            $uploadSuccess = $file->upload(BASE_ROOT . $data['picture'], $pictureName);
            if (!$uploadSuccess) {
                $alertsManager->addAlert((new Alerts\Alert())->setState(false)->setMessage("Impossible d'upload l'image " . $file->getName() . "."));
                header('Location: /admin/teachers');
                exit();
            }
            $data['picture'] .= $pictureName;
        } else {
            unset($data['picture']);
        }


        $state = $teacherManager->update($id, $data);

        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) {
            $alert->setMessage('Le bureau a été mise à jour.');
        } else {
            $alert->setMessage('Impossible de mettre à jour le bureau.');
        }

        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        header("Location: /admin/teachers");
        exit();
    }
}
