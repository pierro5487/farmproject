<?php

namespace Manager;

class BuildingManager
{
    public function getListBuilding($pdo, $idUser)
    {
        $sql='SELECT building.id, name, level_access, building.level as level, level*5 as max_quantity, building.date_created as date, image_path, price_improvement 
              FROM type_building 
              INNER JOIN building ON type_building.id = building.id_type
              WHERE id_user = :idUser
              ORDER BY id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('idUser'=>$idUser));
        return $stmt->fetchAll();
    }
}