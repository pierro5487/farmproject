<?php

namespace Controller;

use \W\Controller\Controller;

class BuildingController extends Controller
{
    public function displayBuilding()
    {
        $this->allowTo('user');
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $dataBuilding = new\Manager\BuildingManager();
        $buildings = $dataBuilding->getListBuilding($pdo, $_SESSION['user']['id']);
        $this->show('Game/building', ['buildings'=>$buildings]);
    }

    public function refreshBuilding()
   {
        $this->allowTo('user');
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $refreshBuilding = new\Manager\BuildingManager();
        $buildings = $refreshBuilding->upgradeBuilding($pdo, building.id);
        $connectBdd = new\Manager\ConnectManager();
        $refreshBuilding2 = new\Manager\BuildingManager();
        $buildings2 = $refreshBuilding2->refreshBuilding($pdo,$_SESSION['user']['id'] );
        $this->show('ajax/building_refresh', ['buildings2'=>$buildings2]);
    }

//    public function upgradeBuilding()
//    {
//        $this->allowTo('user');
//        $controller = new\Manager\ConnectManager();
//        $pdo = $controller->connectPdo();
//        $upgradeBuilding = new\Manager\BuildingManager();
//        $buildings = $upgradeBuilding->upgradeBuilding($pdo, $_SESSION['user']['id']);
//        $this->show('Game/building', ['buildings'=>$buildings]);
//    }
//
//    public function refreshBuilding()
//    {
//        $this->allowTo('user');
//        $controller = new\Manager\ConnectManager();
//        $pdo = $controller->connectPdo();
//        $refreshBuilding = new\Manager\BuildingManager();
//        $buildings = $refreshBuilding->refreshBuilding($pdo, $_SESSION['user']['id']);
//        $this->show('Game/building', ['buildings'=>$buildings]);
//    }
    public function upgradeBuilding()
    {

        //je crée un object PDO
        $connectBdd = new \Manager\ConnectManager();
		$pdo = $connectBdd->connectPdo();
        //j'upgrade le batiment sélectionné
        $buildingManager =  new\Manager\BuildingManager();
        $buildingManager->setTable('building');
        $building = $buildingManager->find($_POST['id']);
        $buildingManager->update(['level'=>$building['level']+1],$_POST['id']);
        $donnees = $buildingManager->refreshBuilding($pdo,$_POST['id']);
        echo(json_encode($donnees));
        
    }

}