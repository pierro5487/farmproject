<?php

namespace Controller;

use \W\Controller\Controller;

class BuildingController extends Controller
{
    public function displayBuilding()
    {
        $this->allowTo('user');
        $controller = new\Manager\ConnectManager();
        $dataBuilding = new\Manager\BuildingManager();
        $buildings = $dataBuilding->getListBuilding($_SESSION['user']['id']);
        $this->show('Game/building', ['buildings'=>$buildings]);
    }

    public function refreshBuilding()
   {
        $this->allowTo('user');
        $controller = new\Manager\ConnectManager();
        $refreshBuilding = new\Manager\BuildingManager();
        $buildings = $refreshBuilding->upgradeBuilding($_POST['id']);
        $connectBdd = new\Manager\ConnectManager();
        $refreshBuilding2 = new\Manager\BuildingManager();
        $buildings2 = $refreshBuilding2->refreshBuilding($_SESSION['user']['id'] );
        $this->show('ajax/building_refresh', ['buildings2'=>$buildings2]);
    }

    public function upgradeBuilding()
    {
        $this->allowTo('user');

        //je crée un object PDO
        $connectBdd = new \Manager\ConnectManager();
        $buildingManager =  new\Manager\BuildingManager();
        //tableau d'erreur
        $errors = [];
        $verifBuilding = $buildingManager->verifBuilding($_POST['id']);

        //vérification si on a assez de po
        if($verifBuilding['price_improvement']*(1+($verifBuilding['level'])/5)>$_SESSION['user']['money']){
            $errors['money'] = true;
        }

        if(count($errors) ==0) {
            //j'upgrade le batiment sélectionné si nous n'avons pas d'erreur
            $buildingManager = new\Manager\BuildingManager();
            $building = $buildingManager->verifBuilding($_POST['id']);
            //amélioration du niveau du batiment
            $buildingManager->update(['level' => $building['level'] + 1], $_POST['id']);
            //on rafraichit l'article contenant le building que l'on souhaite améliorer
            $donnees['building'] = $buildingManager->refreshBuilding($_POST['id']);
            $userManager = new \Manager\UsersManager();
            //retrait des po
            $userManager->spendMoney($_SESSION['user']['id'], $building['price_improvement']*(1+($building['level'])/5));
            $_SESSION['user']['money'] -= $building['price_improvement']*(1+($building['level'])/5);
            $donnees['user']['money'] = $_SESSION['user']['money'];
            $donnees['user']['level']= $_SESSION['user']['level'];
            $userManager= new \Manager\UsersManager();
            //on ajoute l'expérience
            $userManager->updateExperience($_SESSION['user']['id'], $building['xp_improvement']);
            echo(json_encode($donnees));
        } else {
            echo json_encode(['error' => true]);
        }
    }

}