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
		$tryConnection = true;
		if(isset($_POST['sendConnexion'])){
			if (empty($_POST['email'])) {
				$errors['email']['empty'] = true;
				$tryConnection = false; // On n'essaie pas de se connecter
			} else {
				// Nettoyage des caractères spéciaux, avant validation
				$email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
				// Facultatif
				// On teste la validité du email
				$isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

				if (!$isEmailValid) {
					$tryConnection = false;
					$errors['email']['noValid'] = true;
				}
				if (empty($_POST['password'])) {
					$errors['password']['empty'] = true;
					$tryConnection = false;

				} else {
					$password = $_POST['password'];
				}
				$nbTries = new \Manager\AuthentificationManager();
				$controller = new \Manager\ConnectManager();
				$pdo = $controller->connectPdo();
				// Récupération du nombre d'essais
				;
				if($nbTries->getNbLoginTries($pdo, $email) >= 3) {
					$errors['connexion']['nbTries'] = true;
					//Le compte est bloqué en raison d'un trop grand nombre de tentatives
				}
			}
			
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
				$userId = $authentificationManager->isValidLoginInfo($email, $password);
				if($userId != 0){
					//récupération données utilisateur
					$userManager = new \Manager\UsersManager();
					$user= $userManager->find($userId);
					//j'inseres les donnees user dans la session 
					$authentificationManager->logUserIn($user);
					//on remet les trylogin à zéero
					$authentificationManager->resetLoginTries($pdo, $eemail);
					//et on redirige
					$this->redirectToRoute('game_farm');
				}else{
					$errors['connexion']['fail']= true;
					//on ajoute une tentative
					$authentificationManager->addLoginTry($pdo, $email);
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
		if (isset($_POST['save_user'])) {
			$errors = array();

			if (empty($_POST['pseudo'])) {
				// Le pseudo est vide
				$errors['pseudo']['empty'] = true;
			}else{
				$pseudo = filter_var(trim($_POST['pseudo']), FILTER_SANITIZE_SPECIAL_CHARS);
			}

			// Vérifications sur les champs
			if (!empty($_POST['email'])) {

				// Avant de valider un champ, on le nettoie
				$email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
				// Facultatif
				// On teste la validité du email
				$isemailValid = filter_var($email, FILTER_VALIDATE_Eemail);
				if (!$isemailValid) {
					$errors['email']['invalid'] = true;
				}

				// Le email est-il déjà enregistré ?
				$userManager = new \Manager\UsersManager();

				if ($userManager->emailExists($email)) {
					$errors['email']['exists'] = true;
				}
			}
			else {

				// Si le email n'est pas renseigné
				$errors['email']['empty'] = true;
			}

			if (!empty($_POST['pass1'])) {
				if (strlen($_POST['pass1']) < 8 || strlen($_POST['pass1']) > 30) {
					$errors['pass1']['size'] = true;
				}
			} else {

				// Si on a pas précisé de mot de passe
				$errors['pass1']['empty'] = true;
			}

			if (!empty($_POST['pass2'])) {
				if (!empty($_POST['pass1']) && ($_POST['pass1'] !== $_POST['pass2'])) {

					// Si le mot de passe a été rempli, la confirmation aussi,
					// mais les deux sont différents
					$errors['pass2']['different'] = true;
				}
			} else {

				// On a pas renseigné la confirmation de mot de passe
				$errors['pass2']['empty'] = true;
			}

			$lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_SPECIAL_CHARS);
			$firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_SPECIAL_CHARS);

			if (empty($lastname)) {
				// Le nom est vide
				$errors['lastname']['empty'] = true;
			}
			if (empty($firstname)) {
				// Le prénom est vide
				$errors['firstname']['empty'] = true;
			}

			// Le formulaire est valide si je n'ai pas enregistré d'erreurs
			if (count($errors) == 0) {
				$formValid = true;

				// Hash du mot de passe
				$passHashed = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
				$userAdded = insertUser($pdo, $pseudo, $email, $passHashed, $lastname, $firstname);
			}
			$this->show('default/subscription');
		}
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