<?php

namespace Controller;

use \W\Controller\Controller;

class FarmController extends Controller
{

	/**
	 * Page ferme récapitulant toute les données de la ferme (premiere page affiché apres la connection)
	 */
	public function displayFarm()
	{
		$this->allowTo('user');
		$getUserInformations = new \Manager\ConnectManager();
		$getUserInformations->setTable('users');
		$userInformations = $getUserInformations->find($_SESSION['user']['id']);

		$dbh = new \Manager\ConnectManager();
		$pdo = $dbh->connectPdo();
		$id = $_SESSION['user']['id'];

		$getAllUserFarmInformations = new \Manager\dataGameManager();
		$getNbAnimalsInformations = new \Manager\dataGameManager();
		$levelUp = new \Manager\usersManager();
		
		
		$allUserFarmInformations = $getAllUserFarmInformations->getAllUserFarmInformations($pdo, $id);
		$allNbAnimalsInformations = $getNbAnimalsInformations->getNbAnimalsInformations($pdo, $id);
		$experience = 50;// Je simule le gain de 50px
		$levelUpInformations = $levelUp->updateExperience($id, $experience);

		$this->show('Game/farm',[
			'userInformations' => $userInformations,
			'allUserFarmInformations' => $allUserFarmInformations,
			'allNbAnimalsInformations' => $allNbAnimalsInformations,
			'levelUpInformations' => $levelUpInformations,
		]);
	}
}