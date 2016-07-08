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
    public function resetLoginTries($pdo, $mail)
    {
        $sql = 'UPDATE Users SET nb_tries = 0 WHERE mail LIKE :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    }
}