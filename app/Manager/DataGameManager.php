<?php

namespace Manager;


class dataGameManager
{
    /**
     * Récupére les informations de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getUserInformations($pdo, $email)
    {
        $sql = 'SELECT * FROM Users WHERE email LIKE :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Récupére toutes les informations de la ferme de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getAllUserFarmInformations($pdo, $id)
    {
        return array(
            'buildings' => self::getUserBuildingsInformations($pdo, $id),
            'animals' => self::getUserAnimalsInformations($pdo, $id),
            'fields' => self::getUserFieldsInformations($pdo, $id),
            'products' => self::getUserProductsAnimalsInformations($pdo, $id),
        );
    }

    /**
     * Récupére les animaux de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getUserAnimalsInformations($pdo, $id)
    {
        $sql = 'SELECT * FROM animals INNER JOIN species ON id_species = species.id WHERE animals.id_user LIKE :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    /**
     * Récupére le nombre d'animaux de l'utilisateur en fonction de leurs epsèces
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getNbAnimalsInformations($pdo, $id)
    {
        $sql = 'SELECT species.name, count(*) as nb_animals FROM animals, species where id_species = species.id and animals.id_user LIKE :id group by id_species';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Récupére les batiments de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getUserBuildingsInformations($pdo, $id)
    {
        $sql = 'SELECT species.name,type_building.name , count(*) as nb_building, sum(level)*5 as max_quantity FROM building, type_building, species WHERE id_type = type_building.id and id_species = species.id and building.id_user LIKE :id group by id_type ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Récupére les champs de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getUserFieldsInformations($pdo, $id)
    {
        $sql = 'SELECT *, count(*) as nb_field  FROM field INNER JOIN variety_cereals ON id_variety = variety_cereals.id WHERE field.id_user LIKE :id group by id_variety';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*    /**
         * Récupére les produits de l'utilisateur
         *
         * @param PDO $pdo Connexion à la base de données
         * @param string $email E-mail
         * @return tableau multidimensionnel
         */
    public function getUserProductsAnimalsInformations($pdo, $id)
    {

        // SELECT s2.quantity, vc.name FROM `stocks2` s2 JOIN users u ON (s2.id_users=u.id), variety_cereals vc where s2.stock_type='field' AND s2.`id_product`=vc.id GROUP BY vc.id
        // SELECT s2.quantity, pa.name FROM `stocks2` s2 JOIN  users u ON (s2.id_users=u.id), product_animal pa where s2.stock_type='animal' AND s2.`id_product`=pa.id GROUP BY pa.id
        $sql = 'SELECT s2.quantity, vc.name FROM `stocks2` s2 JOIN users u ON (s2.id_users=:id), variety_cereals vc where s2.stock_type=\'field\' AND s2.`id_product`=vc.id GROUP BY vc.id UNION SELECT s2.quantity, pa.name FROM `stocks2` s2 JOIN  users u ON (s2.id_users=:id), product_animal pa where s2.stock_type=\'animal\' AND s2.`id_product`=pa.id GROUP BY pa.id';
        //$sql = 'SELECT *, count(*) as count FROM stocks INNER JOIN product_animal ON id_product_animal = product_animal.id WHERE id_users LIKE :id group by id_species';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}