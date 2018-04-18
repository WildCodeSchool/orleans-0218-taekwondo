<?php
namespace Controller;

use Model\Album\Manager;
use Model\Form;

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
        $form = (new Form\Response())->fromSession();
        if ($form !== null) $form->clearSession();

        return $this->twig->render('Album/Admin/Category/index.html.twig', [
            'lastFormResult' => $form
        ]);
    }

    /**
     * (Admin)[Form] Create a new category
     * @return string
     */
    public function adminCategoryCreate(): string
    {
        if (empty($_POST)) exit();

        $name = trim(strip_tags($_POST['name']));

        if (empty($name)) exit();

        $categoryManager = new Manager\Category();
        $query = $categoryManager->create($name);

        $response = new Form\Response();
        $response->setState($query);
        if ($response->getState()) $response->setMessage('Catégorie ajoutée.');
        else $response->setMessage('Impossible d\'ajouter la catégorie.');
        $response->updateSession();

        header("Location: /admin/albums/categories");
        exit();
    }
}