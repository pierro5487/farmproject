<?php

namespace Controller;

use \W\Controller\Controller;

class FieldController extends Controller
{
   public function displayField()
   {
       $this->allowTo('user');
       $fields=$this->getFields();
       $this->show('Game/field',['fields'=>$fields]);
   }

    public function getFields()
    {
        $controller = new\Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $dataFields = new\Manager\FieldManager();
        $fields = $dataFields->getListFields($pdo, $_SESSION['user']['id']);
        //on récupere le temps
        $timeManager = new \Manager\OptionsManager();
        $options = $timeManager->find(1);
        //on affiche le template
        foreach ($fields as $key=>$field){
            $timeHarvest = $field['timestamp_harvest']*$options['time'];
            $timeNow=time()-strtotime($field['date_sow']);
            $fieldValue=floor(($timeNow*100)/$timeHarvest);
            $fields[$key]['fieldValue']=$fieldValue;
        }
        return $fields;
    }
}