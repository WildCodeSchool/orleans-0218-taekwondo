<?php
/**
 * Created by PhpStorm.
 * User: sapuraizu
 * Date: 28/03/18
 * Time: 11:01
 */

namespace Controller;

class HomeController extends AbstractController
{
    public function index(): string
    {
        $event = [
            'title' => 'Titre exemple',
            'date' => time(),
            'description' => 'Description des activités de l\'event',
            'image' => 'assets/images/flyers.jpg'
        ];

        return $this->twig->render('Home/index.html.twig', [
            'events' => [ $event, $event, $event ]
        ]);
    }
}