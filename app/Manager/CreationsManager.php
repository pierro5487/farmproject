<?php

namespace Manager;

class CreationsManager
{
    public function getUserCreationsInformations($pdo)
    {
        $sql = 'SELECT * FROM type_building';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}