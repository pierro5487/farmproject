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
        $animal = $animalsManager->getAnimal($pdo,$idAnimal);
        //je récupere les donnees utilisateur
        $connectBdd = new \Manager\ConnectManager();
        $connectBdd->setTable('users');
        $user = $connectBdd->find($_SESSION['user']['id']);
        //je credit son compte
        $newMoney=$user['money']+$animal['price_sale'];
        $_SESSION['user']['money']=$newMoney;
        //j'insere la nouvelle solde
        $data =['money'=>$newMoney];
        $connectBdd->update($data,$_SESSION['user']['id']);
        //je supprime l'animal
        $connectBdd->setTable('animals');
        $connectBdd->delete($idAnimal);
        //je récupere la liste des animaux apartenant à mon user
        $dataAnimals= new\Manager\AnimalsManager();
        $animals= $dataAnimals->getListAnimals($pdo,$_SESSION['user']['id']);
        $this->show('ajax/animals_refresh',['animals'=>$animals]);
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
        $product = $productsManager->getProduct($pdo,$idProduct);
        //je récupere les donnees utilisateur
        $connectBdd = new\Manager\ConnectManager();
        $connectBdd->setTable('users');
        $user = $connectBdd->find($_SESSION['user']['id']);
        //je credit son compte
        $newMoney=$user['money']+$product['price_sale']*$product['quantity'];
        $_SESSION['user']['money']=$newMoney;
        //j'insere la nouvelle solde
        $data =['money'=>$newMoney];
        $connectBdd->update($data,$_SESSION['user']['id']);
        //je supprime la production
        $connectBdd->setTable('stocks');
        $connectBdd->delete($idProduct);
        //je récupere la liste des produits apartenant à mon user
        $dataProducts= new\Manager\ProductsManager();
        $products= $dataProducts->getUserProductsInformations($pdo,$_SESSION['user']['id']);
        $this->show('ajax/products_refresh',['products'=>$products]);
    }

    public function userRefresh()
    {
        $userManager = new\Manager\ConnectManager();
        $userManager->setTable('users');
        $user = $userManager->find($_SESSION['user']['id']);
        $this->show('ajax/user_info_refresh',['user'=>$user]);
    }

    public function productsRefresh()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $productionController = new \Controller\ProductionController();
        $productsGroup = $productionController->calculHarvest();
        $this->show('ajax/article_products_refresh',['products'=> $productsGroup]);
    }

    public function chatRefresh()
    {
        $chatManager = new \Manager\ChatManager();
        $connectManager = new \Manager\ConnectManager();
        $connectManager->setTable('users');
        //je prend les 5 derniers message
        $posts=$chatManager->getPost();
        $posts=array_reverse($posts);
        foreach ($posts as $key=>$post){
            //pour chaque message je récupère le login du user et je l'insere dans les donnees messages
            $user = $connectManager->find($post['id_user']);
            $posts[$key]['login']=$user['login'];
        }
        echo json_encode($posts);
    }

    public function chatSendMessage()
    {
        $message=filter_var($_GET['message'],FILTER_SANITIZE_SPECIAL_CHARS);
        $connectManager = new \Manager\ConnectManager();
        $connectManager->setTable('tchat');
        $connectManager->insert(['message'=>$message,'id_user'=>$_SESSION['user']['id']]);

    }
}