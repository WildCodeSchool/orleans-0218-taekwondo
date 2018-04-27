<?php

namespace Controller;

use Model\Event;
use Model\Footer;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class HomeController extends AbstractController
{
    public function index(): string
    {
        $eventManager = new Event\Manager();

        return $this->twig->render('Home/index.html.twig', [
            'events' => $eventManager->selectAllEventAsc(),
            'map_access_token' => MAP_ACCESS_TOKEN,
            'training_rooms' => [
                [
                    'id' => 'uniq_room_first',
                    'name' => 'Salle d\'entraînement #1',
                    'address' => '27 rue non nommée',
                    'lat' => 47.89455472852978,
                    'lng' => 1.8482355333803753,
                    'infos' => 'Desservi par les lignes de bus 12 et 13.'
                ],
                [
                    'id' => 'uniq_room_second',
                    'name' => 'Salle d\'entraînement #2',
                    'address' => '72 rue non nommée',
                    'lat' => 47.87134566839059,
                    'lng' => 1.9567255236147503,
                    'infos' => 'Desservie par les lignes de bus 13 et 11.'
                ]
            ],
            'links' => (new Footer\LinkManager())->getAll(),
        ]);
    }

    /**
     * @return void
     */
    public function contactCreate(): void
    {

        // Adresse de la page de provenance de la requête du formulaire
        $origin = $_SERVER['HTTP_REFERER'];


        // Vérification reCaptcha

        // Ma clé privée
        $secret = APP_CAPTCHA_SECRET_KEY;
        // Paramètre renvoyé par le recaptcha
        $response = $_POST['g-recaptcha-response'];
        // IP de l'utilisateur
       $remoteip = $_SERVER['REMOTE_ADDR'];

        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $response
            . "&remoteip=" . $remoteip ;

        $decode = json_decode(file_get_contents($api_url), true);


        // Si le formulaire est INcomplet
        if (empty($_POST['courriel']) || empty($_POST['message']) || ($decode['success'] == false)) {

            header("Location: $origin");
            exit();


        // Quand le formulaire est complet
        } else {


            // Avec "if", on vérifie que le système reCAPTCHA ai identifié celui qui fait la requête comme un humain
            // Dans ce cas, le courriel est traité puis envoyé
            if ($decode['success'] == true) {

                // Utilisation de la librairie SwiftMailer pour la gestion des courriels
                // Fonctionnement en 4 étapes

                // 1) Create the Transport
                $transport = (new Swift_SmtpTransport(APP_MAIL_HOST, APP_MAIL_PORT, APP_MAIL_SECURITY))
                    ->setUsername(APP_MAIL_NAME)
                    ->setPassword(APP_MAIL_PWD);


                // 2) Create the Mailer using your created Transport
                $courrier = new Swift_Mailer($transport);


                // 3) Create a message
                $contact = (new Swift_Message)
                    ->setTo([APP_MAIL_TO => 'PO'])
                    ->setBody(trim(strip_tags($_POST['message'])))
                    ->setFrom([trim(strip_tags($_POST['courriel'])) => 'Visiteur du site'])
                    ->setSubject(APP_MAIL_SUBJECT);


                // 4) Send the message
                $result = $courrier->send($contact);


                unset($_POST);
                header("Location: $origin");
                exit();
            }
        }

    }

}
