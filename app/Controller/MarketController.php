<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22/07/2016
 * Time: 14:52
 */

namespace Controller;


class MarketController extends \W\Controller\Controller
{
    public function displayMarket()
    {
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $marketManager=$this->marketAnimalsRefresh();
        //on récupere la liste d'animaux
        $animalsList=$marketManager->getMarketAnimalsList($pdo);
        $animalsList=$this->calculFreeLocation($animalsList);
        $this->show('Game/market',['animalsList' => $animalsList]);
    }

    public function marketAnimalsRefresh()
    {
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $animalsManager = new \Manager\AnimalsManager();

        $idNbSpecies = $animalsManager->getNbSpecies($pdo);

        $nbAnimals = rand(10, 30);

        // On recupere les animaux encore présent sur le marché
        $marketManager= new \Manager\MarketManager();
        $animal=$marketManager->findAll();
        //je récupere le jour de création
        $timeManager = new\Manager\OptionsManager();
        $time=$timeManager->getTimestampMarket();
        //on test si la liste est du jour
        if(date('N',$time) != date('N')){
            //on vide le marché des animaux restant
            $marketManager->deleteAll($pdo);
            //on créé les animaux aléatoirement
            for ($i=0;$i< $nbAnimals; $i++){
                $idNbSpecies = rand(1, $idNbSpecies);
                $animals[] = new \Classes\Animals($idNbSpecies);
            }
            //on les insere en bdd
            foreach ($animals as $key=>$animal){
                $data=[
                    'id_species'=>$animals[$key]->getIdSpecies()
                ];
                $marketManager->insert($data);
            }
            //on change la date du marché
            $timeManager->updateTimestamp();
        }
        return $marketManager;
    }
    public function calculFreeLocation($animalsList)
    {
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $species=[];
        foreach ($animalsList as $key=>$animal){
            $specieExist=false;
            foreach ($species as $idSpecie=>$specie){
                if($animal['id_species']==$idSpecie){
                    $specieExist=true;
                }
            }
            if(!$specieExist){
                //je recupere le type_building correspondant a mon animal
                $typeBuildingManager= new \Manager\BuildingTypeManager();
                $typeBuilding=$typeBuildingManager->find($animal['id_species']);
                //je recupere le nombre de batiment correspondant au type de l'animal
                $buildingManager= new \Manager\BuildingManager();
                $buildings=$buildingManager->getBuildingListOfType($typeBuilding['id'],$_SESSION['user']['id']);
                //je calcul la place qu'offre ces batiments
                $location=0;
                foreach ($buildings as $building){
                    $location+=$building['level']*5;
                }
                //je récupère le nombre d'animal de ce type
                $animalsManager= new \Manager\AnimalsManager();
                $nbAnimals=$animalsManager->getAnimalsSameTypeList($pdo,$_SESSION['user']['id'],$animal['id_species']);
                $freeLocation=false;
                if($location-$nbAnimals>0){
                    $freeLocation=true;
                }
                $animalsList[$key]['location']=$freeLocation;
            }
        }
        return $animalsList;
    }
}
/*//je verife si l'user à le batiment requis ainsi que la place pour l'animal
//je recupere le type_building correspondant a mon animal
$typeBuildingManager= new \Manager\BuildingTypeManager();
$typeBuilding=$typeBuildingManager->find($animal['id_species']);
//je recupere le nombre de batiment correspondant au type de l'animal
$buildingManager= new \Manager\BuildingManager();
$buildings=$buildingManager->getBuildingListOfType($typeBuilding['id'],$_SESSION['user']['id']);
//je calcul la place qu'offre ces batiments
$location=0;
foreach ($buildings as $building){
    $location+=$building['level']*5;
}
//je récupère le nombre d'animal de ce type
$animalsManager= new \Manager\AnimalsManager();
$nbAnimals=$animalsManager->getAnimalsSameTypeList($pdo,$_SESSION['user']['id'],$animal['id_species']);*/