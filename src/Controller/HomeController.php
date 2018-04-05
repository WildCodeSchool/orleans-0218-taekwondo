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
        return $this->twig->render('Home/index.html.twig', [
            'presentation'=> [
                'image' => 'http://via.placeholder.com/350x150',
                'title' => 'Présentation du club',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel augue tempor justo molestie congue. Aliquam quam nisi, vehicula eget metus sed, sollicitudin ultricies mauris.',
            ]
        ]);
    }
}