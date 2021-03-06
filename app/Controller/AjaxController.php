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
        //je recupere l'id de l'animal selectionné
        $idAnimal = $_GET['animal'];
        //je recupere les données de l'animal
        $animalsManager = new\Manager\AnimalsManager();
        $animal = $animalsManager->getAnimal($pdo, $idAnimal);
        //je récupere les donnees utilisateur
        $connectBdd = new \Manager\ConnectManager();
        $user = $connectBdd->find($_SESSION['user']['id']);
        //je credit son compte
        $newMoney = $user['money'] + $animal['price_sale'];
        $_SESSION['user']['money'] = $newMoney;
        //j'insere la nouvelle solde
        $data = ['money' => $newMoney];
        $connectBdd->update($data, $_SESSION['user']['id']);
        //je supprime l'animal
        $connectBdd->setTable('animals');
        $connectBdd->delete($idAnimal);
        //je récupere la liste des animaux apartenant à mon user
        $dataAnimals = new\Manager\AnimalsManager();
        $animals = $dataAnimals->getListAnimals($pdo, $_SESSION['user']['id']);
        $this->show('ajax/animals_refresh', ['animals' => $animals]);
    }


    public function productsRefreshList()
    {
        $this->allowTo('user');
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //je recupere l'id de la production selectionné
        $idProduct = $_GET['product'];
        //je recupere les données de la production
        $productsManager = new\Manager\ProductsManager();
        $product = $productsManager->getProduct($pdo, $idProduct);
        //je récupere les donnees utilisateur
        $connectBdd = new\Manager\ConnectManager();
        $user = $connectBdd->find($_SESSION['user']['id']);
        //je credit son compte
        $newMoney = $user['money'] + $product['price_sale'] * $product['quantity'];
        $_SESSION['user']['money'] = $newMoney;
        //j'insere la nouvelle solde
        $data = ['money' => $newMoney];
        $connectBdd->update($data, $_SESSION['user']['id']);
        //je supprime la production
        $productsManager->delete($idProduct);
        //je récupere la liste des animaux apartenant à mon user
        $dataProducts = new\Manager\ProductsManager();
        $products = $dataProducts->getUserProductsInformations($pdo, $_SESSION['user']['id']);
        $this->show('ajax/products_refresh', ['products' => $products]);
    }

    public function userRefresh()
    {
        $userManager = new\Manager\ConnectManager();
        $user = $userManager->find($_SESSION['user']['id']);
        $this->show('ajax/user_info_refresh', ['user' => $user]);
    }

    public function productsRefresh()
    {
        $productionController = new \Controller\ProductionController();
        //on recupères les produits animaliers
        $productsGroup = $productionController->calculHarvest();
        //on récupères la liste des champs semés
        $fieldsController = new \Controller\FieldController();
        $fields = $fieldsController->getFields();
        //on vérifie si des champs sont pret à récolter
        $nbrFieldReady = 0;
        foreach ($fields as $field) {
            if ($field['fieldValue'] >= 100) {
                $nbrFieldReady++;
            }
        }
        $this->show('ajax/article_products_refresh', ['products' => $productsGroup, 'fieldsReady' => $nbrFieldReady]);
    }

    public function chatRefresh()
    {
        $chatManager = new \Manager\ChatManager();
        $connectManager = new \Manager\ConnectManager();
        //je prend les 5 derniers message
        $posts = $chatManager->getPost();
        $posts = array_reverse($posts);
        foreach ($posts as $key => $post) {
            //pour chaque message je récupère le login du user et je l'insere dans les donnees messages
            $user = $connectManager->find($post['id_user']);
            $posts[$key]['login'] = $user['login'];
        }
        echo json_encode($posts);
    }


    public function chatSendMessage()
    {
        $message = filter_var($_GET['message'], FILTER_SANITIZE_SPECIAL_CHARS);
        $connectManager = new \Manager\ConnectManager();
        $connectManager->setTable('tchat');
        $connectManager->insert(['message' => $message, 'id_user' => $_SESSION['user']['id']]);
    }

    public function creationsRefresh()
    {
        //je récupere les donnees utilisateur
        $connectBdd = new\Manager\ConnectManager();
        $user = $connectBdd->find($_SESSION['user']['id']);
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        // On créé un objet dataCreations
        // On récupere la liste des creations possible de mon user
        $typeBuildingManager = new\Manager\BuildingTypeManager();
        $creationsGroup = $typeBuildingManager->findAll();

        $typeFieldManager = new\Manager\FieldTypeManager();
        $creationsGroup2 = $typeFieldManager->findAll();

        // Pour l'eventualité de la gestion du temps de construction
        /*$manager = new \Manager\BuildingTypeManager();
        $idCreation = $this->creationsPopup(1);
        $typeBuilding = $manager->find($idCreation); // 1, 2 ou 3 ..*/

        $this->show('ajax/article_creations_refresh', ['creations' => $creationsGroup, 'creations2' => $creationsGroup2, 'user' => $user, /*'typeBuilding' => $typeBuilding*/]);
    }

    public function creationsPopup(/*$test = null*/)
    {
        $manager = new \Manager\BuildingTypeManager();
        $typeBuilding = $manager->find($_GET['idCreation']);

        /*if($test == null){*/
        $this->show('ajax/article_creations_popup', ['typeBuilding' => $typeBuilding]);/*}*/
        /*$idCreation = $_GET['idCreation'];
        return $idCreation;*/
    }

    public function creationsPopup2(/*$test = null*/)
    {
        $manager = new \Manager\FieldTypeManager();
        $typeField = $manager->find($_GET['idCreation2']);
        /*if($test == null){*/
        $this->show('ajax/article_creations_popup2', ['typeField' => $typeField]);/*}*/
        /*$idCreation = $_GET['idCreation'];
        return $idCreation;*/
    }

    public function addBuilding()
    {
        // On crée un object PDO
        $addBuilding = new\Manager\BuildingManager();
        $typeBuildingManager = new\Manager\BuildingTypeManager();
        $typeBuilding = $typeBuildingManager->find($_GET['idCreation']);
        $addBuilding->insert([
            'level' => 1,
            'id_user' => $_SESSION['user']['id'],
            'id_type' => $_GET['idCreation']
        ]);
        $connectBdd = new\Manager\ConnectManager();
        $user = $connectBdd->find($_SESSION['user']['id']);
        // On débite son compte
        $newMoney = $user['money'] - $typeBuilding['price_construction'];
        $_SESSION['user']['money'] = $newMoney;
        // On insere le nouveau solde de compte
        $connectBdd->update(['money' => $newMoney], $_SESSION['user']['id']);
        $userManager = new \Manager\UsersManager();
        $userManager->updateExperience($_SESSION['user']['id'], $typeBuilding['xp_construction']);

    }

    public function addField()
    {
        // On crée un object PDO
        $addField = new\Manager\FieldManager();
        $typeFieldManager = new\Manager\FieldTypeManager();
        $typeField = $typeFieldManager->find($_GET['idCreation2']);
        $addField->insert([
            'id_user' => $_SESSION['user']['id'],
            'id_variety' => $_GET['idCreation2']
        ]);
        $connectBdd = new\Manager\ConnectManager();
        $user = $connectBdd->find($_SESSION['user']['id']);
        // On débite son compte
        $newMoney = $user['money'] - $typeField['price_purchase'];
        $_SESSION['user']['money'] = $newMoney;
        // On insere le nouveau solde de compte
        $connectBdd->update(['money' => $newMoney], $_SESSION['user']['id']);

    }

    public function refreshFields()
    {
        $fieldController = new \Controller\FieldController();
        $fields = $fieldController->getFields();
        echo json_encode($fields);
    }

    public function fieldHarvest()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //je recupere l'id du champs moissonné
        $idField = substr($_GET['id'], 2);
        //je récupere le champs moissonné
        $fieldManager = new \Manager\FieldManager();
        $field = $fieldManager->getField($pdo, $idField);
        //on insere la moisson dans le stock
        $productionController = new \Controller\ProductionController();
        $productionController->cerealHarvest($field);
        //on augmente l 'experience
        $userManager = new \Manager\UsersManager();
        $userManager->updateExperience($_SESSION['user']['id'], $field['xp_harvest']);
        //on supprime le champs
        $fieldManager->delete($idField);
        echo $idField;

    }

    public function refreshMarket()
    {
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $marketController = new\Controller\MarketController();
        $marketManager=$marketController->marketAnimalsRefresh();
        //on récupere la liste d'animaux et on les affiches
        $animalsList=$marketManager->getMarketAnimalsList($pdo);
        $marketController= new \Controller\MarketController();
        $animalsList=$marketController->calculFreeLocation($animalsList);
        $this->show('ajax/market_refresh',['animalsList' => $animalsList]);
    }
    public function buyAnimal()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //je récupère l'id du marché à conclure
        $idMarket=$_GET['idAnimal'];
        //je récupere l'animal acheté
        $marketManager=new \Manager\MarketManager();
        $animal =$marketManager->find($idMarket);
        //je récupere l'argent de l'utilisateur
        $money=$_SESSION['user']['money'];
        //je verife si l'user à le batiment requis ainsi que la place pour l'animal
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
        //je récupère le prix de vente de l'animal
        $specie=$animalsManager->getPurchasePrice($pdo,$animal['id_species']);
        //je verifie que l'utilisateur à l'argent et la place pour habriter cet animal
        if($nbAnimals<$location && $money>$specie['price_purchase'] ){
            //on achete l'animal
            //je le supprime du marché
            $marketManager->delete($idMarket);
            //j'insere ce nouvel animal dans la bdd
            $data=[
                'name'=>$specie['name'].$idMarket,
                'id_user'=>$_SESSION['user']['id'],
                'id_species'=>$animal['id_species']
            ];
            //je retire de l'argent
            $animalsManager->insert($data);
            //je récupere les donnees utilisateur
            $connectBdd = new\Manager\ConnectManager();
            $user = $connectBdd->find($_SESSION['user']['id']);
            //je credit son compte
            $newMoney = $user['money'] - $specie['price_purchase'];
            $_SESSION['user']['money'] = $newMoney;
            //j'insere la nouvelle solde
            $data = ['money' => $newMoney];
            $connectBdd->update($data, $_SESSION['user']['id']);
            //j'insere de l'experience
            //on ajoute l'experience
            $newXp = $specie['xp_purchase'];
            $userManager = new \Manager\UsersManager();
            $userManager->updateExperience($_SESSION['user']['id'],$newXp);
        }else{
            //sinon on redirige vers la page marché les button étant désactivé ce cas ne peut arriver qu'en modifiant html
        }
    }
}