<?php

namespace Manager;

class FieldManager
{
    public function getListFields($pdo, $idUser)
    {
        $sql='SELECT field.id as id, variety_cereals.name as nameCereals, variety_cereals.image_path as image
              FROM field
              INNER JOIN variety_cereals ON variety_cereals.id = field.id_variety
              WHERE id_user = :idUser';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('idUser'=>$idUser));
        return $stmt->fetchAll();
    }
}