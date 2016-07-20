<?php

namespace Controller;

use \W\Controller\Controller;

class CreationsController extends Controller
{


    public function displayCreations()
    {
        $this->allowTo('user');
        // On créé un objet PDO
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        // On créé un objet dataCreations
        $dataCreations= new\Manager\CreationsManager();
        // On récupere la liste des creations possible de mon user
        /*$id=$_GET['idCreation'];*/

        /*$user = $connectBdd->find($_SESSION['user']['id']);*/

        // Affichage avec envoi du tableau
        $this->show('Game/creations'/*,['creations'=>$creations,'id'=>$id]*/);
    }
}