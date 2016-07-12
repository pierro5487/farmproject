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
    private function getUserAnimalsInformations($pdo, $id)
    {
        $sql = 'SELECT *, count(*) as count FROM animals INNER JOIN species ON id_species = species.id WHERE animals.id_user LIKE :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
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
        $sql = 'SELECT *, count(*) as count, level*5 as maxQuantity FROM building INNER JOIN type_building ON id_type = type_building.id WHERE building.id_user LIKE :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
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
        $sql = 'SELECT *, count(*) as count  FROM field INNER JOIN variety_cereals ON id_variety = variety_cereals.id WHERE field.id_user LIKE :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Récupére les produits de l'utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $email E-mail
     * @return tableau multidimensionnel
     */
    public function getUserProductsAnimalsInformations($pdo, $id)
    {
        $sql = 'SELECT *, count(*) as count FROM stocks INNER JOIN product_animal ON id_product_animal = product_animal.id WHERE id_users LIKE :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

}