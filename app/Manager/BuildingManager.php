<?php

namespace Manager;

class BuildingManager
{
    public function getListBuilding($pdo, $idUser)
    {
        $sql='SELECT name, level_access, building.level as level, building.date_created as date, image_path 
              FROM type_building 
              INNER JOIN building ON type_building.id = building.id_type
              WHERE id_user = :idUser';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('idUser'=>$idUser));
        return $stmt->fetchAll();
    }
}