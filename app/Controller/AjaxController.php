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
        $connectBdd->setTable('users');
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
        $connectBdd->setTable('stocks');
        $connectBdd->delete($idProduct);
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

    private function calculHarvest()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //récupération du temps
        $timeManager = new\Manager\OptionsManager();
        $timeManager->setTable('options');
        $options = $timeManager->find(1);
        $time = $options['time'];
        /*---------récupération produit animaliers------*/
        //je recupere le nombre d'animaux par espece et la caratéristique temps de production de chaque espece
        $dataAnimals = new\Manager\AnimalsManager();
        $animals = $dataAnimals->getAllInfoAnimals($pdo, $_SESSION['user']['id']);
        //on parcourt un à un chaque animal pour evaluer sa production
        $productsGroup = [];
        foreach ($animals as $animal) {
            //calcul production depuis la derniere récolte
            $now = time();
            $lastHarvest = strtotime($animal['last_harvest']);
            $productTime = $now - $lastHarvest;
            $timeToProduct = $animal['time_product'] * $time;
            $nbProduct = floor($productTime / $timeToProduct);
            //regroupement des produit
            if (isset($productsGroup[$animal['species']])) {
                $productsGroup[$animal['species']]['nb'] += $nbProduct;
            } else {
                $productsGroup[$animal['species']]['nb'] = $nbProduct;
                $productsGroup[$animal['species']]['productName'] = $animal['productName'];
                $productsGroup[$animal['species']]['unity'] = $animal['unity'];
                $productsGroup[$animal['species']]['idProduct'] = $animal['id_product'];
            }
        }
        return $productsGroup;
    }

    public function productsRefresh()
    {
        $productsGroup = $this->calculHarvest();
        $this->show('ajax/article_products_refresh', ['products' => $productsGroup]);
    }

    public function harvest()
    {
        //on récupère la production
        $productsGroup = $this->calculHarvest();
        //on test si les stocks existe déja pour ce produits

        //on envoi les nouveaux produits dans la bdd
        //on parcourt un à un chaque animal pour evaluer sa production

        //on recharge la liste de la production
        $this->productsRefresh();
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

        $typeBuildingManager = new\Manager\dataGameManager();
        $creationsGroup2 = $typeBuildingManager->getUserFieldsInformations($pdo,$_SESSION['user']['id']);
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
}