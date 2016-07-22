<?php

namespace Manager;

class FieldManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('field');
    }

    public function getListFields($pdo, $idUser)
    {
        $sql='SELECT field.id as id, variety_cereals.name as nameCereals, variety_cereals.image_path as image, timestamp_harvest, date_sow
              FROM field
              INNER JOIN variety_cereals ON variety_cereals.id = field.id_variety
              WHERE id_user = :idUser';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('idUser'=>$idUser));
        return $stmt->fetchAll();
    }

    public function getField($pdo,$idField)
    {
        $req=$pdo->prepare('SELECT * FROM field f INNER JOIN variety_cereals vc ON f.id_variety=vc.id WHERE f.id=:idField ');
        $req->execute(array('idField'=>$idField));
        return $req->fetch();
    }
}