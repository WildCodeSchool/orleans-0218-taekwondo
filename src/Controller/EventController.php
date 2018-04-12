<?php
/**
 * Created by PhpStorm.
 * User: takne
 * Date: 11/04/18
 * Time: 17:10
 */

namespace Controller;
use Model\Event;

class EventController extends AbstractController
{
    public function index(): string
    {
        $eventManager = new Event\Manager();

        return $this->twig->render('Event/index.html.twig', [
            'events' => $eventManager->selectAllEvent()
        ]);
    }



}