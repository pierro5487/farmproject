<?php

namespace Controller;

use \W\Controller\Controller;

class GameController extends Controller
{

	/**
	 * Page ferme récapitulant toute les données de la ferme (premiere page affiché apres la connection)
	 */
	public function displayFarm()
	{

		$this->allowTo('user');
		$this->show('Game/farm');
	}

	// fonction creé seulement pour se déconnecter pendant les test avec l url /deconnect
	public function logOut()
	{
		$authentificationManager = new \Manager\AuthentificationManager();
		$authentificationManager->logUserOut();
		$this->redirectToRoute('home');
	}

}