<?php

namespace Manager;

class AnimalsManager extends \w\Manager\Manager
{
    public function getListAnimals($pdo, $id)
    {
        $req = $pdo->prepare('SELECT *,animals.id as idAnimal,species.name as name_species, animals.name as nameAnimal FROM animals INNER JOIN species ON animals.id_species=species.id WHERE id_user=:id ORDER BY species.name');
        $req->execute(array('id' => $id));
        return $req->fetchAll();
    }

    public function getAnimal($pdo, $id)
    {
        $req = $pdo->prepare('SELECT *,animals.id as idAnimal,species.name as name_species FROM animals INNER JOIN species ON animals.id_species=species.id WHERE animals.id=:id');
        $req->execute(array('id' => $id));
        return $req->fetch();
    }
    public function getAllInfoAnimals($pdo, $id)
    {
        $req = $pdo->prepare('SELECT *,an.id as idAnimal,sp.name as species,pa.name as productName,pa.id as id_product FROM animals an INNER JOIN species sp ON an.id_species=sp.id INNER JOIN product_animal pa ON pa.id_species=sp.id WHERE id_user=:id');
        $req->execute(array('id' => $id));
        return $req->fetchAll();
    }

    public function setLastHarvestNow($pdo,$idUser,$idProduct)
    {
        $sql=('UPDATE animals an SET last_harvest = NOW() WHERE id_user=:id AND id_species =(SELECT id_species FROM product_animal WHERE id=:idProduct)');
        $req = $pdo->prepare($sql);
        $req->execute(array(
            'id'        => $idUser,
            'idProduct' => $idProduct
        ));
    }
}