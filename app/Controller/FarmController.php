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

		$getAllUserFarmInformations = new \Manager\dataGameManager();
		$getNbAnimalsInformations = new \Manager\dataGameManager();
		$allUserFarmInformations = $getAllUserFarmInformations->getAllUserFarmInformations($pdo, $_SESSION['user']['id']);
		$allNbAnimalsInformations = $getNbAnimalsInformations->getNbAnimalsInformations($pdo, $_SESSION['user']['id']);
		$this->show('Game/farm',[
			'userInformations' => $userInformations,
			'allUserFarmInformations' => $allUserFarmInformations,
			'allNbAnimalsInformations' => $allNbAnimalsInformations,
		]);
	}
}