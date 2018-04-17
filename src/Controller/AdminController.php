<?php
namespace Controller;

class AdminController extends AbstractController {
    public function index(): string
    {
        return $this->twig->render('Admin/index.html.twig');
    }
}