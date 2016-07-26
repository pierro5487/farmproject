<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Connexion</title>
	</head>
	<link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/connexion.styles.css')?>">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />
	<body>
		<form action="#" method="POST" accept-charset="utf-8">
			<div class="vid-container">
				<video class="bgvid" autoplay="autoplay" muted="muted" preload="auto" loop>
					<source src="https://d2v9y0dukr6mq2.cloudfront.net/video/preview/okUindP/tractor-cycle-cartoon_hupss54n__PM.mp4" type="video/webm">
				</video>
				<div class="inner-container">
					<video class="bgvid inner" autoplay="autoplay" muted="muted" preload="auto" loop>
						<source src="https://d2v9y0dukr6mq2.cloudfront.net/video/preview/okUindP/tractor-cycle-cartoon_hupss54n__PM.mp4?random=1" type="video/webm">
					</video>
				</div>
			</div>

			<div class="container">

				<div class="box">
					<img src="<?= $this->assetUrl('img/connexion_cow.png')?>">
					<?php if(!empty($_SESSION['user']['message'])) : ?>
						<script>
							/*On passe la variable php à JS*/
							var message = "<?= $_SESSION['user']['message']?>";
							document.write("<div id='message' class='error' style='display: none;'>"+message+"</div>");
							$('#message').fadeIn(1000);
							$('#message').fadeOut(6000);
							// Définition de la boite de dialogue
						</script>
					<?php endif ?>
					<!--On vide la variable en session-->
					<?php $_SESSION['user']['message'] = ''; ?>
					<?php if (isset($errors['connexion']['nbTries'])) echo '<div class="error">Le compte est bloqué en raison d\'un trop grand nombre de tentatives</div>'; ?>
					<?php if (isset($errors['connexion']['fail'])) echo '<div class="error">Le mot de passe ne correspond pas</div>'; ?>
					<h1>Lor'N Farm</h1>
					<div class="field">
						<input type="email" name ="email" placeholder="E-mail"/>
						<?php if (isset($errors['email']['empty'])) echo '<div class="error">Entrez un e-mail</div>'; ?>
						<?php if (isset($errors['email']['noValid'])) echo '<div class="error">L\'e-mail n\'est pas valide</div>'; ?>
					</div>
					<div class="field">
						<input type="password" name="password" placeholder="Mot de passe"/>
						<?php if (isset($errors['password']['empty'])) echo '<div class="error">Entrez un mot de passe</div>'; ?>
					</div>
					<div class="field">
						<button type="submit" name ="sendConnexion">Connexion</button>
						<p>Pas encore membre ? <span><a href="<?= $this->url('subscription')?>">Inscription</a></span></p>
						<p><span><a href="<?= $this->url('recovery-password')?>">Mot de passe perdu ?</a></span></p>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>