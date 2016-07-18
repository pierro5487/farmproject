<?php

namespace Controller;

use \W\Controller\Controller;

class FieldController extends Controller
{
   public function displayField()
   {
       $this->allowTo('user');
       $controller = new\Manager\ConnectManager();
       $pdo = $controller->connectPdo();
       $dataFields = new\Manager\FieldManager();
       $fields = $dataFields->getListFields($pdo, $_SESSION['user']['id']);
       $this->show('Game/field',['fields'=>$fields]);
   }
}