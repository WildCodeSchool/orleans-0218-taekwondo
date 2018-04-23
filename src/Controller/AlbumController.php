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
        // Retrieve alerts
        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        // Check if we want to edit a category
        $categoriesManager = new Manager\Category();
        $editId = !empty($_GET['editId']) ? (int)$_GET['editId'] : 0;
        $category = null;
        if ($editId > 0 && $categoriesManager->existsById($editId))
            $category = $categoriesManager->selectOneById($editId);

        // Twig render
        return $this->twig->render('Album/Admin/Category/index.html.twig', [
            'alerts' => $alerts,
            'categories' => $categoriesManager->getAll(),
            'selection' => $category
        ]);
    }

    /**
     * (Admin)[Form] Create a new category
     * @return string
     */
    public function adminCategoryCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['name'])) header('Location: /admin/albums/categories');
        $name = trim(strip_tags($_POST['name']));
        if (empty($name)) header('Location: /admin/albums/categories');

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
        header('Location: /admin/albums/categories');
        exit();
    }

    /**
     * (Admin)[Form] Update a category
     * @param int $id
     * @return string
     */
    public function adminCategoryUpdate(int $id): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['name']))
            header('Location: /admin/albums/categories');
        $data = [
            'name' => trim(strip_tags($_POST['name']))
        ];
        if (empty($data['name']) || $id <= 0) header('Location: /admin/albums/categories');

        // Try to update the category
        $categoriesManager = new Manager\Category();
        if (!$categoriesManager->existsById($id)) header('Location: /admin/albums/categories');
        $state = $categoriesManager->update($id, $data);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Catégorie modifiée');
        else $alert->setMessage('Impossible de modifier la catégorie.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/albums/categories');
        exit();
    }

    /**
     * (Admin)[Form] Delete a category
     * @param int $id
     * @return string
     */
    public function adminCategoryDelete(int $id): string
    {
        // 'Verifications'
        if ($id <= 0) header('Location: /admin/albums/categories');

        // Try to delete the category
        $categoriesManager = new Manager\Category();
        if (!$categoriesManager->existsById($id)) header('Location: /admin/albums/categories');
        $state = $categoriesManager->delete($id);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Catégorie supprimée.');
        else $alert->setMessage('Impossible de supprimer la catégorie.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/albums/categories');
        exit();
    }

    /**
     * (Admin) Return the CRUD view of Galleries
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminGalleriesIndex(): string
    {
        // Retrieve alerts
        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        // Managers
        $categoriesManager = new Manager\Category();
        $galleriesManager = new Manager\Gallery();

        return $this->twig->render('Album/Admin/Gallery/index.html.twig', [
            'alerts' => $alerts,
            'categories' => $categoriesManager->getAll(),
            'galleries' => $galleriesManager->getAll()
        ]);
    }

    /**
     * (Admin)[Form] Create a new gallery
     * @return string
     */
    public function adminGalleryCreate(): string
    {
        // 'Verifications'
        if (empty($_POST) || empty($_POST['categoryId']) || empty($_POST['title']) || empty($_POST['description']))
            header('Location: /admin/albums/galleries');

        $categoryId = (int)$_POST['categoryId'];
        $title = trim(strip_tags($_POST['title']));
        $description = trim(strip_tags($_POST['description']));

        if (empty($title) || empty($description) || $categoryId <= 0)
            header('Location: /admin/albums/galleries');

        // Check if the gallery exists
        $categoriesManager = new Manager\Category();
        if (!$categoriesManager->existsById($categoryId)) header('Location: /admin/albums/galleries');

        // Try to create the gallery
        $galleriesManager = new Manager\Gallery();
        $state = $galleriesManager->insert([
            'title' => $title,
            'description' => $description,
            'category_id' => $categoryId
        ]);

        // Create a new alert
        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('Galerie crée.');
        else $alert->setMessage('Impossible de créer la galerie.');

        // Push the alert to the global list
        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        // Redirection
        header('Location: /admin/albums/galleries');
        exit();
    }

    /**
     * (Admin) Return the EDIT view of a gallery
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function adminGalleryUpdateIndex(int $id): string
    {
        $galleriesManager = new Manager\Gallery();
        if (!$galleriesManager->existsById($id)) return '';
        $categoriesManager = new Manager\Category();

        $alertsManager = new Alerts\Manager();
        $alerts = $alertsManager->getAlerts();
        $alertsManager->clean();

        return $this->twig->render('Album/Admin/Gallery/Update/index.html.twig', [
            'gallery' => $galleriesManager->getOne($id),
            'categories' => $categoriesManager->getAll(),
            'alerts' => $alerts
        ]);
    }

    /**
     * (Admin)[Form] Edit a gallery
     * @param int $id
     * @return string
     */
    public function adminGalleryUpdate(int $id): string
    {
        $galleriesManager = new Manager\Gallery();
        if (!$galleriesManager->existsById($id)) return '';

        $data = [
            'title' => trim(strip_tags($_POST['title'])),
            'description' => trim(strip_tags($_POST['description'])),
            'category_id' => (int)$_POST['categoryId']
        ];

        $categoriesManager = new Manager\Category();
        if (!$categoriesManager->existsById($data['category_id'])) return '';

        $state = $galleriesManager->update($id, $data);

        $alert = new Alerts\Alert();
        $alert->setState($state);
        if ($alert->getState()) $alert->setMessage('La galerie a été mise à jour.');
        else $alert->setMessage('Impossible de mettre à jour la galerie.');

        $alertsManager = new Alerts\Manager();
        $alertsManager->addAlert($alert);

        header("Location: /admin/albums/gallery/$id/update");
        exit();
    }
}