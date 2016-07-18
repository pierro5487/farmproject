<?php

namespace Manager;

class BuildingManager extends \w\Manager\Manager
{
    public function getListBuilding($pdo, $idUser)
    {
        $sql='SELECT building.id, name, level_access, building.level as level, level*5 as max_quantity, building.date_created as date, image_path, price_improvement 
              FROM type_building 
              INNER JOIN building ON type_building.id = building.id_type
              WHERE id_user = :idUser
              ORDER BY building.id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function upgradeBuilding($pdo, $idBuilding)
    {
        $sql='UPDATE building SET level = level+1 WHERE building.id= :idBuilding';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idBuilding', $idBuilding);
        $stmt->execute();
    }

    public function refreshBuilding($pdo, $idBuilding)
    {
        $sql='SELECT building.id, name, level_access, building.level as level, level*5 as max_quantity, building.date_created as date, image_path, price_improvement 
	        FROM type_building 
	        INNER JOIN building ON type_building.id = building.id_type
	        WHERE building.id = :idBuilding
	        ORDER BY building.id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idBuilding', $idBuilding);
        $stmt->execute();
        return $stmt->fetch();
    }
}