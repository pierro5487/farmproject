<?php

namespace Controller;

use \W\Controller\Controller;

class AnimalsController extends Controller
{
	

	public function displayAnimals()
	{
		$this->allowTo('user');
		//je créé un objet pdo
		$controller = new \Manager\ConnectManager();
		$pdo = $controller->connectPdo();
		//je créé un objet dataAnimals
		$dataAnimals= new\Manager\AnimalsManager();
		//je récupere la liste des animaux apartenant à mon user
		$animals= $dataAnimals->getListAnimals($pdo,$_SESSION['user']['id']);
		
		$this->show('Game/animals',['animals'=>$animals]);
	}
}