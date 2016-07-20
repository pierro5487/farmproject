<?php

namespace Manager;

use W\Manager\UserManager;

class UsersManager extends UserManager
{
    // Possibilité d'augmenter l'xp et également sans paramètre de calculé le nouveau niveau
    public function updateExperience($id, $experience = null)
    {
        /* Calcul du level*/

        $user = $this->find($id); // On récupère les infos de l'utilisateur
        $L = $user['level']; // Level actuel
        $max_experience = $user['max_experience']; // Level actuel

        $newExperience = $user['experience']+ $experience; // Ajout de l'xp en bdd
        $this->update(['experience' => $newExperience], $id);

        /* Fonction exponentielle permettant l'augmentation du level par le biais du nombre d'xp */
        $newLevel = floor((25 + sqrt(625 + 100 * $newExperience)) / 50);

        $X = 25 * $L * $L - 25 * $L; // Xp max du niveau précédent
        /*On récupère l'exp nécessaire au level suivant*/
        $totalXpNextLevel=(pow(50*$newLevel-25,2)-625)/100;
        /*On fait la différence pour récupère seulement le nombre d'xp nécessaire*/
        $xpRequire = $totalXpNextLevel - $X;
        /*Pour ne pas écrasé la dernière valeure*/
        if($xpRequire != 0){
            $this->update(['max_experience' => $xpRequire], $id);
        }

        /* On soustrait l'xp*/
        $currentXp = $user['experience'] - $X;

        $this->update(['Level' => $newLevel], $id);

        //Find() à effectuer levelUp en bdd, affiche script alert levelUp
        if ($newLevel > $user['level']){
            $this->update(['levelUp' => true], $id);
        }

        /*Fin calcul du level*/

            return array(
                'max_experience' => $max_experience,
                'current_xp' => $currentXp,
            );
    }
}