<?php 

namespace Manager;

use W\Security\AuthentificationManager as AManager;

class AuthentificationManager extends AManager
{
    /**
     * Récupérer le nombre d'essais de connexion
     *
     * @param PDO $pdo Connexion à la base de données
     * @param string $mail E-mail
     * @return integer Le nombre d'essais
     */
    public function getNbLoginTries($pdo, $email)
    {
        $sql = 'SELECT nb_tries FROM Users WHERE email LIKE :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchColumn(0);
    }

    /**
     * Incrémenter le nombre d'essais d'un utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param type string $mail E-mail
     */
    public function addLoginTry($pdo, $email)
    {
        $sql = 'UPDATE Users SET nb_tries = nb_tries + 1 WHERE email LIKE :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    }
    /**
     * Réinitialiser le nombre d'essais d'un utilisateur
     *
     * @param PDO $pdo Connexion à la base de données
     * @param type string $mail E-mail
     */
    public function resetLoginTries($pdo, $email)
    {
        $sql = 'UPDATE Users SET nb_tries = 0 WHERE email LIKE :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    }

    /**
     * Ajouter un utilisateur en base de données
     * @param   $pdo Connexion PDO à la DB
     * @param   $mail Email
     * @param   $password Mot de passe hashé
     * @param   $lastname Nom de famille
     * @param   $firstname Prénom
     * @return bool : le succès de l'insertion
     */
    public function insertUser($pdo, $pseudo, $email, $password, $lastname, $firstname)
    {
        $sqlInsert = 'INSERT INTO Users (pseudo, email, password, lastname, firstname, role) VALUES ' .
            '(:pseudo, :email, :pass, :lname, :fname, :role)';
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->bindValue(':pseudo', $pseudo);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pass', $password);
        $stmt->bindValue(':lname', $lastname);
        $stmt->bindValue(':fname', $firstname);
        $role = 'user';
        $stmt->bindValue(':role', $role);
        return $stmt->execute();
    }
}