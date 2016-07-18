<?php

namespace Controller;

use \W\Controller\Controller;

class ProductsController extends Controller
{


    public function displayProducts()
    {
        $this->allowTo('user');
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //je créé un objet dataAnimals
        $dataProducts= new\Manager\ProductsManager();
        /*//je récupere la liste des produit animalier apartenant à mon user
        $animalsProducts= $dataProducts->getListAnimalsProducts($pdo,$_SESSION['user']['id']);
        //je récupere la liste des produit cerealier apartenant à mon user
        $fieldProducts= $dataProducts->getListCerealsProducts($pdo,$_SESSION['user']['id']);*/
        $products = $dataProducts->getUserProductsInformations($pdo, $_SESSION['user']['id']);
        $this->show('Game/products',['products'=>$products]);
    }
}