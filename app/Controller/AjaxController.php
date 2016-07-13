<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 13/07/2016
 * Time: 09:11
 */

namespace Controller;

use \W\Controller\Controller;

class AjaxController extends Controller
{
    public function animalsRefreshList()
    {
        $this->allowTo('user');
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //je vend l'animal selectionner
        $idAnimal = $_GET['animal'];
        //je recupere les données de l'animal
        $animalsManager = new\Manager\AnimalsManager();
        $animal = $animalsManager->getAnimal($pdo,$idAnimal);
        //je supprime l'animal
        /*$connectBdd->delete($idAnimal);*/
        //je récupere les donnees utilisateur
        $connectBdd = new\Manager\ConnectManager();
        $connectBdd->setTable('users');
        $user = $connectBdd->find($_SESSION['user']['id']);
        //je credit son compte
        $newMoney=$user['money']+$animal['price_sale'];
        //j'insere la nouvelle solde
        $data =['money'=>$newMoney];
        $connectBdd->update($data,$_SESSION['user']['id']);
        $dataAnimals= new\Manager\AnimalsManager();
        //je récupere la liste des animaux apartenant à mon user
        $animals= $dataAnimals->getListAnimals($pdo,$_SESSION['user']['id']);
        $this->show('ajax/animals_refresh',['animals'=>$animals]);
    }
}