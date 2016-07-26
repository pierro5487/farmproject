<?php

namespace Controller;

class ProductionController extends \W\Controller\Controller
{
    public function calculHarvest()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //récupération du temps
        $timeManager = new\Manager\OptionsManager();
        $time=$timeManager->getTime();
        /*---------récupération produit animaliers------*/
        //je recupere le nombre d'animaux par espece et la caratéristique temps de production de chaque espece
        $dataAnimals= new\Manager\AnimalsManager();
        $animals= $dataAnimals->getAllInfoAnimals($pdo,$_SESSION['user']['id']);
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
                $productsGroup[$animal['species']]['productName']=$animal['productName'];
                $productsGroup[$animal['species']]['unity']=$animal['unity'];
                $productsGroup[$animal['species']]['idProduct']=$animal['id_product'];
                $productsGroup[$animal['species']]['xp_sale']=$animal['xp_sale'];
                $productsGroup[$animal['species']]['volume']=$animal['volume'];
            }
            //on calcul le nombre de produit max que l'on peut stocké
            $nbMax = $animal['volume']*$_SESSION['user']['level'];
            $productsGroup[$animal['species']]['nbMax'] = $nbMax;
            //on verifie que le nombre de produit du meme type ne dépasse pas le nombre max de stockage
            if($productsGroup[$animal['species']]['nb']>$nbMax){
                $productsGroup[$animal['species']]['nb'] = $nbMax;
            }
        }
        return $productsGroup;
    }
    
    public function harvest(){
        //on récupère la production
        $productsGroup = $this->calculHarvest();
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //on récupère les stock existants
        $dataProducts= new\Manager\ProductsManager();
        $stocks= $dataProducts->getAnimalsProductsStock($pdo,$_SESSION['user']['id']);
        //on test si les stocks existe déja pour ce produit
        $dataProducts->setTable('stocks');
        $animalsManager = new \Manager\AnimalsManager();
        foreach ($productsGroup as $product){
            $stockExist=false;
            foreach ($stocks as $stock){
                if($product['idProduct'] == $stock['id_product']){
                    //si le stock existe on ajoute la quantité
                    $stockUpdating = $dataProducts->find($stock['id']);
                    $dataProducts->update(['quantity'=>$stockUpdating['quantity']+$product['nb']],$stock['id']);
                    $stockExist=true;
                }
            }
            if(!$stockExist && $product['nb']!=0){
                //on créé le stock si il n'existe pas
                $data=[
                    'id_users'    => $_SESSION['user']['id'],
                    'id_product'  => $product['idProduct'],
                    'quantity'    => $product['nb'],
                    'stock_type'  => 'animal'
                ];
                $dataProducts->insert($data);
            }
            //si onrecolte une quantité non null
            if($product['nb']!=0){
                //on remet ensuite la variable derniere récolte à jour pour chaque animal qui produit ce produit
                $animalsManager->setLastHarvestNow($pdo,$_SESSION['user']['id'],$product['idProduct']);
                //on ajoute l'experience
                $newXp = $product['nb']*$product['xp_sale'];
                $userManager = new \Manager\UsersManager();
                $userManager->updateExperience($_SESSION['user']['id'],$newXp);

            }
        }
        $this->redirectToRoute('game_products');
    }
    public function cerealHarvest($field)
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        //récupération du temps
        $timeManager = new\Manager\OptionsManager();
        $options = $timeManager->find(1);
        //je récupère tout les stocks existant
        $dataProducts= new\Manager\ProductsManager();
        $stocks= $dataProducts->getCerealsProductsStock($pdo,$_SESSION['user']['id']);
        //on teste si le champs est bien pret à etre récolté en cas de triche(modification html)
        $timeHarvest = $field['timestamp_harvest']*$options['time'];
        $timeNow=time()-strtotime($field['date_sow']);
        $fieldValue=floor(($timeNow*100)/$timeHarvest);
        if($fieldValue>=100){
            //si champs est pret
            //on teste si les céréales récoltés ont déja un stock existant
            $stockExist=false;
            foreach ($stocks as $stock){
                if($field['id_variety'] == $stock['id_product']){
                    //si le stock existe on ajoute la quantité
                    $stockUpdating = $dataProducts->find($stock['id']);
                    $dataProducts->update(['quantity'=>$stockUpdating['quantity']+$field['harvest_quantity']],$stock['id']);
                    $stockExist=true;
                }
            }
            if(!$stockExist ){
                //on créé le stock si il n'existe pas
                $data=[
                    'id_users'    => $_SESSION['user']['id'],
                    'id_product'  => $field['id_variety'],
                    'quantity'    => $field['harvest_quantity'],
                    'stock_type'  => 'field'
                ];
                $dataProducts->insert($data);
            }

        }
    }
}