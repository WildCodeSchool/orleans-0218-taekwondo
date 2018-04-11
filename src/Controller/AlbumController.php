<?php
namespace Controller;

use Model\Album\Category;
use Model\Album\Gallery;
use Model\Album\Image;

class AlbumController extends AbstractController {
    public function index(): string
    {
        $data = [
            'search' => !empty($_GET['search']) ? trim(strip_tags($_GET['search'])) : '',
            'categoryId' => !empty($_GET['categoryId']) ? intval($_GET['categoryId']) : 0
        ];

        $categoriesManager = new Category\Manager();
        $galleriesManager = new Gallery\Manager();

        return $this->twig->render('Album/index.html.twig', [
            'GET' => $data,
            'galleries' => $galleriesManager->getAll($data['categoryId'], $data['search']),
            'categories' => $categoriesManager->getAll()
        ]);
    }

    public function gallery(int $id): string
    {
        $galleryManager = new Gallery\Manager();
        $imageController = new Image\Manager();

        return $this->twig->render('Album/gallery.html.twig', [
            'gallery' => $galleryManager->getOne($id),
            'images' => $imageController->getByGalleryId($id)
        ]);
    }
}