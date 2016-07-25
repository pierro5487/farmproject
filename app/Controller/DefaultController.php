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
			if (empty($_POST['email'])) {
				$errors['email']['empty'] = true;
			} else {
				// Nettoyage des caractères spéciaux, avant validation
				$email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);

				// On teste la validité du email
				$isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

				if (!$isEmailValid) {
					$errors['email']['noValid'] = true;
				}
				if (empty($_POST['password'])) {
					$errors['password']['empty'] = true;

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

			/*---- redirection en fonction des erreurs-----------*/
			//si j'ai des erreurs dans formulaire je renvoie direct au formulaire avec les erreurs 
			//sinon je test le login,le mot de passe est bien dans la bdd et correct
			//si c'est faux je renvoi le formulaire ;si c'est ok je récupères les infos user et les password à la session grace à logUserIn() voir doc
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
					$authentificationManager->resetLoginTries($pdo, $email);
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
				// On teste la validité du email
				$isemailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
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

				// Hash du mot de passe
				$passHashed = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
				$controller = new \Manager\ConnectManager();
				$pdo = $controller->connectPdo();

				$authentificationManager = new \Manager\AuthentificationManager();
				$authentificationManager->insertUser($pdo, $pseudo, $email, $passHashed, $lastname, $firstname);
			}
			$this->show('default/subscription', ['errors'=>$errors]);
		}
		$this->show('default/subscription');
	}

	/*--------------------------------------------------------------------------*/


	/**
	 * redirige vers la page de récupération du mot de passe
	 */
	public function recoveryPassword()
	{
		if(isset($_POST['recovery'])){
			//une demande à été faite
			/*--traitement email reçu en *POST-----*/
			// Avant de valider un champ, on le nettoie
			$email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
			if (!empty($_POST['email'])) {
				// On teste la validité du email
				$isemailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
				if (!$isemailValid) {
					$errors['email']['invalid'] = true;
				}
			}else{
				//champ email vide
				$errors['email']['empty'] = true;
			}
			// Le email est-il déjà enregistré ?
			$userManager = new \Manager\UsersManager();
			if (!$userManager->emailExists($email)) {
				//il n'existe pas j'affiche le template en envoyant l erreur mail noexist
				$errors['email']['noExist'] = true;
				$this->show('default/recovery-password',['errors'=>$errors]);
			}
			/*------test si il y a des erreurs j envoi les erreur sinon je valide l'envoi du tokens --------*/
			if(isset($errors)){
				$this->show('default/recovery-password',['errors'=>$errors]);
			}else{
				//je créé un token,je l 'insere en bdd et j'envoi l email
                $token = \W\Security\StringUtils::randomString(32);
                $controller = new \Manager\ConnectManager();
                $pdo = $controller->connectPdo();
				$userManager = new \Manager\UsersManager();
				$user = $userManager->getUserByUsernameOrEmail($email);
				$authentificationManager = new \Manager\AuthentificationManager();
                $authentificationManager->postToken($pdo,$user['id'],$token);
				$this->sendMail($email,$token,$user['id']);

			}

		}else{
			//sinon j'affiche le formulaire de demande de recovery
			$this->show('default/recovery-password');
		}
	}

	private function sendMail($email,$token,$id)
	{

		$mail = new \PHPMailer();

		$mail->isSMTP();                                      	// On va se servir de SMTP
		$mail->Host = 'smtp.gmail.com';  				// Serveur SMTP
		$mail->SMTPAuth = true;                               	// Active l'autentification SMTP
		$mail->Username = 'mail.wf3@gmail.com';             	// SMTP username
		$mail->Password = 'mailwf3741';                   		// SMTP password
		$mail->SMTPSecure = 'tls';                            	// TLS Mode
		$mail->Port = 587;                                    	// Port TCP à utiliser

		$mail->Sender='mailer@monsite.fr';
		$mail->setFrom('mailer@monsite.fr', 'Lor\'N Farm', false);
		$mail->addAddress($email);     		// Ajouter un destinataire
//		$mail->addAddress('ellen@example.com');               	// Le nom est optionnel
		$mail->addReplyTo('contact@monsite.fr', 'Information');
//		$mail->addCC('cc@example.com');
		$mail->addBCC('bcc@example.com');

		$mail->isHTML(true);                                  	 // Set email format to HTML
		$mail->CharSet = 'UTF-8';


		$mail->addEmbeddedImage('../public/assets/img/cow.png','cow_image');
		$mail->addEmbeddedImage('../public/assets/img/cow2.png','cow2_image');
		$mail->Subject = 'Changement de mot de passe';
        $message = "
			<style type=\"text/css\">
				section{
					display: block;
					width: 100%;
				}
				section::before{
				content:'';
				display: block;
				clear: both;
				}
				h4{
					font-size: 2em;
					font-weight: bold;
					padding: 20px 0px;
					float: left;
					display: block;
				}
				img{
					display: block;
					float: left;
					width: 100px;
					height: 100px;
					margin-left: 20px;
					margin-right: 20px;
				}
				a{
					font-weight: bold;
				}
			</style>
			<section>
				<img tag put src=\"cid:cow_image\">
				<h4>Bien le bonjour!</h4>
				<img tag put src=\"cid:cow2_image\">
			</section>
			<div class='clearfix''></div>
			
			<section>
				<p>Vous avez oublié votre mot de passe? Vous souhaitez le changer? Et bien voici! Tâchez bien de cliquer sur le lien et votre voeu sera exaucé!</p><br>
				<p><a href=\"localhost / farmproject /public/new-password ? token = '.$token.' & id = '.$id.'\">Cliquez ici</a></p><br>
				<p>Bonne continuation et amusez vous bien sur <strong>Lor'N Farm</strong></p><br>
				<p>Vous n'êtes pas à l'origine de ce mail? Faites donc comme si vous ne l'aviez jamais reçu et go à la corbeille!</p><br>
			</section>";


		$mail->Body    = $message;
		$mail->AltBody = 'Le message en texte brut, pour les clients qui ont désactivé l\'affichage HTML';

		if(!$mail->send()) {
			echo 'Le message n\'a pas pu être envoyé';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Le message a été envoyé';
		}


	}

    public function setNewPassword()
    {
        //si j ai une requete
        if(isset($_GET['token'])|| isset($_POST['new-password'])){
			//si c une requete post
			if(isset($_POST['new-password'])){
				//je récupere les password1 et 2
				$pass1 = $_POST['password1'];
				$pass2 = $_POST['password2'];
				//je recupere l'id
				$id=$_GET['id'];

				/*----verificztion mot de passe------*/
				if (!empty($pass1)) {
					if (strlen($pass1) < 8 || strlen($pass1) > 30) {
						$errors['pass1']['size'] = true;
					}
				} else {

					// Si on a pas précisé de mot de passe
					$errors['pass1']['empty'] = true;
				}

				if (!empty($pass2)) {
					if (!empty($pass1) && ($pass1 !== $pass2)) {

						// Si le mot de passe a été rempli, la confirmation aussi,
						// mais les deux sont différents
						$errors['pass2']['notSame'] = true;
					}
				} else {

					// On a pas renseigné la confirmation de mot de passe
					$errors['pass2']['empty'] = true;
				}
				/*-------------------------------------------------------*/
				if(isset($errors)){
					$this->show('default/new-password',['errors'=>$errors]);
				}else{
					//pas d'erreurs on enregistre le nouveau password
					$bddManager = new \Manager\ConnectManager();
					$data=['password'=>password_hash($pass1, PASSWORD_DEFAULT)];
					$bddManager->update($data,$id);
					//et on supprime le token
					$controller = new \Manager\ConnectManager();
					$pdo = $controller->connectPdo();
					$bddManager->setTable('recovery_token');
					$bddManager->deleteToken($pdo,$id);
					$this->show('default/new-password',['validationPassword'=>true]);
				}
			}
            //si c une requete get
            if(isset($_GET['token'])){
                $token = $_GET['token'];
                $controller = new \Manager\ConnectManager();
                $pdo = $controller->connectPdo();
                $authentificationManager = new \Manager\AuthentificationManager();
                if($user = $authentificationManager->tokenExist($pdo,$token)){
                    //si le token existe dans la bdd j'affiche le formulaire nouveau mot de passe
                    $this->show('default/new-password',['user'=>$user]);
                }else{
					$this->redirectToRoute('home');
                }
            }

        }else{
            //pas de requete je renvoi vers la page recovery-password
			$this->redirectToRoute('recovery-passwords');
        }
    }
	// fonction creé seulement pour se déconnecter pendant les test avec l url /deconnect
	public function logOut()
	{
		$authentificationManager = new \Manager\AuthentificationManager();
		$authentificationManager->logUserOut();
		$this->redirectToRoute('home');
	}
}