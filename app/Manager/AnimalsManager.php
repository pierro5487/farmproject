<?php

namespace Manager;

class AnimalsManager
{
    public function getListAnimals($pdo, $id)
    {
        $req = $pdo->prepare('SELECT *,animals.id as idAnimal,species.name as name_species FROM animals INNER JOIN species ON animals.id_species=species.id WHERE id_user=:id');
        $req->execute(array('id' => $id));
        return $req->fetchAll();
    }

    public function getAnimal($pdo, $id)
    {
        $req = $pdo->prepare('SELECT *,animals.id as idAnimal,species.name as name_species FROM animals INNER JOIN species ON animals.id_species=species.id WHERE animals.id=:id');
        $req->execute(array('id' => $id));
        return $req->fetch();
    }
}