<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">

	<!-- LOCAL -->
	<script src="<?=$this->assetUrl('js/jquery-2.2.3.min.js')?>"></script>
	<!-- SCRIPT PERSO -->
	<script>
		var ajaxAnimalRefresh= '<?= $this->url('ajax_refresh_animals') ?>';
	</script>
	<script src="<?=$this->assetUrl('js/script.js')?>"></script>
    <script src="<?=$this->assetUrl('js/ajaxScript.js')?>"></script>
</head>
<body>
<header>
	<div class="container">
		<div>
			<h1><?= $this->e($title) ?></h1>
			<!-- insertion logo -->
			<img src="" alt="logo">
		</div>

		<div id="infoUser">
			<!-- affichage du pseudo -->
			<div><?= $_SESSION['user']['login'] ?></div>
			<!-- affichage de l'xp -->
			<div>Level <?= $_SESSION['user']['level'] ?></div>
			<!-- affichage des po -->
			<div><?= $_SESSION['user']['money'] ?> PO</div>
			<!-- bouton déconnexion-->
			<a href="<?= $this->url('game_log_out')?>">Déconnexion</a>
		</div>
		<div class="clearfix"></div>
		<!-- navigation -->
		<nav>
			<ul>
				<li class="viber"><a href="<?= $this->url('game_farm')?>" id="farm">ferme</a></li>
				<li class="viber"><a href="<?= $this->url('game_animals')?>">bâtiments</a></li>
				<li class="viber"><a href="<?= $this->url('game_animals')?>">animaux</a></li>
				<li class="viber"><a href="#">cultures</a></li>
				<li class="viber"><a href="#">produits</a></li>
				<div class="clearfix"></div>
			</ul>
		</nav>
	</div>
</header>

<main>
	<div class="container">
		<section id="navLeft">
			<!-- Section création -->
			<article>
				<h5>les creations</h5>
				<a href="#">Bâtiments</a>
				<a href="#">Champs</a>
				<div class="clearfix"></div>
			</article>

			<!-- Section mes produits -->
			<article id="products">
				<h5>mes produits</h5>
				<!-- Nom du produit -->
				<div></div>
				<!-- Délais d'obtention du produit en forme de jauge -->
				<div></div>
				<!-- Bouton de récolte du produit -->
				<button type="submit" name="harvest">Récolter</button>
			</article>

			<!-- Section tchat -->
			<article>
				<h5>le tchat</h5>
				<!-- Le tchat -->
				<div id="chat">
					<form method="post" action="#" id="messageForm">
						<textarea name="message" id="message" placeholder="Message" cols="20" rows="2"></textarea>
						<button type="submit">Envoyer</button>
					</form>
				</div>
			</article>
		</section>

		<a id="buttonNavLeft" href="#"></a>

		<section id="content">
			<?= $this->section('main_content') ?>
		</section>
	</div>
</main>

<footer>
	<p class="container">&copy; copyright - 2016 &reg;</p>
</footer>
</body>
</html>