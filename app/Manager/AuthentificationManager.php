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
    public function insertUser($pdo, $login, $email, $password, $lastname, $firstname)
    {
        $sqlInsert = 'INSERT INTO users (login, email, password, lastname, firstname, role) VALUES ' .
            '(:login, :email, :pass, :lname, :fname, :role)';
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pass', $password);
        $stmt->bindValue(':lname', $lastname);
        $stmt->bindValue(':fname', $firstname);
        $role = 'user';
        $stmt->bindValue(':role', $role);
        return $stmt->execute();
    }

    public function postToken($pdo, $id_user, $token)
    {
        //et on supprime d'abord un eventuel token déja demandé
        $bddManager = new \Manager\ConnectManager();
        $bddManager->setTable('recovery_token');
        $bddManager->deleteToken($pdo,$id_user);
        //puis on insere
        $stmt = $pdo->prepare('INSERT INTO recovery_token (id_user, token) VALUES(:id_user, :token)');
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }



    public function tokenExist($pdo, $token)
    {
        $stmt = $pdo->prepare('SELECT id_user FROM recovery_Token where token=:token');
        $stmt->bindParam(':token', $token);
        $stmt->execute();
		return $stmt->fetchColumn(0);/*il faudrait que je retourne l id du user*/
	}
}