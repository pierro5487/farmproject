<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">
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
					<div>pseudo</div>
					<!-- affichage de l'xp -->
					<div>XP</div>
					<!-- affichage des po -->
					<div>po</div>
					<!-- bouton déconnexion-->
					<button type="submit" name="disconnect">Déconnexion</button>
				</div>
				<div class="clearfix"></div>
				<!-- navigation -->
				<nav>
					<ul>
						<li><a href="#">Ma ferme</a></li>
						<li><a href="#">Mes bâtiments</a></li>
						<li><a href="#">Mes animaux</a></li>
						<li><a href="#">Mes cultures</a></li>
						<li><a href="#">Mes produits</a></li>
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
						<div></div>
					</article>
				</section>

				<section id="containe">
					<?= $this->section('main_content') ?>
				</section>
			</div>
		</main>

		<footer>
				<p class="container">&copy; copyright - 2016 &reg;</p>
		</footer>
</body>
</html>