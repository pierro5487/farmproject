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
}