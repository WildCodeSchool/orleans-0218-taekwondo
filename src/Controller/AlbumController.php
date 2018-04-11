<?php
namespace Controller;

use Model\Album\Gallery;

class AlbumController extends AbstractController {
    public function index(): string
    {
        $galleriesManager = new Gallery\Manager();
        return $this->twig->render('Album/index.html.twig', [
            'galleries' => $galleriesManager->getAll()
        ]);
    }
}