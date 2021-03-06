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
		$userInformations = $getUserInformations->find($_SESSION['user']['id']);

		$dbh = new \Manager\ConnectManager();
		$pdo = $dbh->connectPdo();
		$id = $_SESSION['user']['id'];

		$getAllUserFarmInformations = new \Manager\DataGameManager();
		$getNbAnimalsInformations = new \Manager\dataGameManager();
		$levelUp = new \Manager\UsersManager();
		
		
		$allUserFarmInformations = $getAllUserFarmInformations->getAllUserFarmInformations($pdo, $id);
		$allNbAnimalsInformations = $getNbAnimalsInformations->getNbAnimalsInformations($pdo, $id);
		$levelUpInformations = $levelUp->updateExperience($id);

		$this->show('Game/farm',[
			'userInformations' => $userInformations,
			'allUserFarmInformations' => $allUserFarmInformations,
			'allNbAnimalsInformations' => $allNbAnimalsInformations,
			'levelUpInformations' => $levelUpInformations,
		]);
	}
}