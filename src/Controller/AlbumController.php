<?php
namespace Controller;

use Model\Album\Manager;

class AlbumController extends AbstractController {
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

    public function gallery(int $id): string
    {
        $galleryManager = new Manager\Gallery();
        $imageController = new Manager\Image();

        return $this->twig->render('Album/gallery.html.twig', [
            'gallery' => $galleryManager->getOne($id),
            'images' => $imageController->getByGalleryId($id)
        ]);
    }
}