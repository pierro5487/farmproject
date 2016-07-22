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
        $animalsManager = new \Manager\AnimalsManager();

        $idNbSpecies = $animalsManager->getNbSpecies($pdo);

        $nbAnimals = rand(10, 30);

        // On recupere les animaux encore présent sur le marché
        $marketManager= new \Manager\MarketManager();
        $animal=$marketManager->findAll();
        //on test si la liste est du jour
        if(date('N',strtotime($animal[0]['date_created'])) != date('N')){
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
        }
        //on récupere la liste d'animaux et on les affiches
        $animalsList=$marketManager->getMarketAnimalsList($pdo);
        $this->show('Game/market',['animalsList' => $animalsList]);
    }
}