<?php
namespace Controller;

class RegisterController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Register/index.html.twig');
    }
}