<?php
namespace Controller;

class AlbumController extends AbstractController {
    public function index(): string
    {
        return $this->twig->render('Album/index.html.twig', [
            'galleries' => [
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0],
                [ 'id' => 0, 'name' => 'Ma galerie', 'nbImages' => 0]
            ]
        ]);
    }
}