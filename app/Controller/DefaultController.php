<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		if(isset($_POST['sendConnexion'])){
			//verification formulaire a faire
			
			//$login pour login et $password pour password
			// $login='user';
			// $password='webforce3';

			/*---- redirection en fonction des erreurs-----------*/
			//si j'ai des erreurs dans formulaire je renvoie direct au formulaire avec les erreurs 
			//sinon je test le login et le mot de pass est bien dans la bdd et correct
			//si c'est faux je renvoi le formulaire ;si c'est ok je récupères les info user et les passe à la session grace à logUserIn()voir doc
			/*------------------------------------------------------*/
			if(!isset($errors)){
				$authentificationManager = new \Manager\AuthentificationManager();
				$userId = $authentificationManager->isValidLoginInfo($login, $password);
				if($userId != 0){
					//récupération données utilisateur
					$userManager = new \Manager\UserManager();
					$user= $userManager->find($userId);
					//j'inseres les donnees user dans la session 
					$authentificationManager->logUserIn($user);
					$this->redirectToRoute('game_farm');
				}else{
					$errors['connection']='connexion échouée ,veuillez vérifiez votre émail et votre mot de passe';
				}
			}
			$this->show('default/home',['errors'=>$errors]);
		}
		/*----pas de post premiere page visulalisé-----*/
		$this->show('default/home');
	}

	/*--------------------------------------------------------------------------*/

	/**
	 * Redirige vers la page d'inscription
	 */
	public function subscription()
	{
		$this->show('default/subscription');
	}

	/*--------------------------------------------------------------------------*/


	/**
	 * redirige vers la page de récupération du mot de passe
	 */
	public function recoveryPassword()
	{
		$this->show('default/recovery-password');
	}


}