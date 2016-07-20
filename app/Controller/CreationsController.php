<?php

namespace Controller;

use \W\Controller\Controller;

class CreationsController extends Controller
{
    // Affichage des creations
    public function displayCreations()
    {
        $this->allowTo('user');
        // On créé un objet PDO
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        // On créé un objet dataCreations
        $dataCreations= new\Manager\CreationsManager();
        // Affichage avec envoi du tableau
        $this->show('Game/creations');
    }
}