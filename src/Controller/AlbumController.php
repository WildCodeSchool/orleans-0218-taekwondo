<?php
namespace Controller;

use Model\Album\Manager;
use Model\Session\Alerts;

class AlbumController extends AbstractController {

    /**
     * (Site) Return the list of available galleries
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(): string
    {
        $data = [
            'search' => !empty($_GET['search']) ? trim(strip_tags($_GET['search'])) : '',
            'categoryId' => !empty($_GET['categoryId']) ? intval($_GET['categoryId']) : 0
        ];

        $categoriesManager = new Manager\Category();
        $galleriesManager = new Manager\Gallery();

        return $this->twig->render('Album/index.html.twig', [
            'GET' => $data,
            'galleries' => $galleriesManager->getAll($data['categoryId'], $data['search']),
            'categories' => $categoriesManager->getAll()
        ]);
    }

    /**
     * (Site) Return the detail of one gallery
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function gallery(int $id): string
    {
        $galleryManager = new Manager\Gallery();
        $imageController = new Manager\Image();

        return $this->twig->render('Album/gallery.html.twig', [
            'gallery' => $galleryManager->getOne($id),
            'images' => $imageController->getByGalleryId($id)
        ]);
    }

    /**
     * (Admin) Return the CRUD view of Categories
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminCategoriesIndex(): string
    {
        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();
        return $this->twig->render('Album/Admin/Category/index.html.twig', [
            'alerts' => $alerts
        ]);
    }

    /**
     * (Admin)[Form] Create a new category
     * @return string
     */
    public function adminCategoryCreate(): string
    {
        // 'Verifications'
        if (empty($_POST)) exit();

        $name = trim(strip_tags($_POST['name']));

        if (empty($name)) exit();

        // Try to create the category
        $categoryManager = new Manager\Category();
        $state = $categoryManager->create($name);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Catégorie ajoutée.');
        else $alert->setMessage('Impossible d\'ajouter la catégorie.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header("Location: /admin/albums/categories");
        exit();
    }
}