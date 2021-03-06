<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="initial-scale=1.0,user-scalable=yes"/>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('jquery-ui-1.12.0.custom/jquery-ui.css')?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">

	<script>
		var ajaxAnimalRefresh= '<?= $this->url('ajax_refresh_animals') ?>';
		var ajaxBuildingUpgrade='<?= $this->url('ajax_upgrade_buldings') ?>';
		var ajaxProductsRefresh= '<?= $this->url('ajax_refresh_products') ?>';
		var tableBoardRefresh= '<?= $this->url('ajax_refresh_user_info') ?>';
		var productsRefresh= '<?= $this->url('ajax_refresh_article_products') ?>';
		var harvestRoute= '<?= $this->url('ajax_harvest') ?>';
		var chatRefresh='<?= $this->url('chatRefresh') ?>';
		var chatSendMessage='<?= $this->url('chatSendMessage') ?>';
		var creationsRefresh= '<?= $this->url('ajax_creations') ?>';
		var creationsPopup= '<?= $this->url('ajax_creations_popup') ?>';
		var ajaxBuildingAdd= '<?= $this->url('ajax_building_add') ?>';
		var ajaxFieldAdd= '<?= $this->url('ajax_field_add') ?>';
		var creationsPopup2= '<?= $this->url('ajax_creations_popup2') ?>';
		var refreshFields='<?= $this->url('refreshFields') ?>';
		var fieldHarvestRoute='<?= $this->url('fieldHarvestRoute') ?>';
		var market='<?= $this->url('refresh_market') ?>';
		var ajaxBuyAnimal='<?= $this->url('buy_animal') ?>';
		var displayFields='<?= $this->url('game_field') ?>';
		var displayBuilding='<?= $this->url('game_building') ?>';
	</script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="<?=$this->assetUrl('jquery-ui-1.12.0.custom/jquery-ui.js')?>"></script>
	<script src="<?=$this->assetUrl('js/script.js')?>"></script>
	<script src="<?=$this->assetUrl('js/ajaxScript.js')?>"></script>
</head>
<body>
<header>
	<div class="container">
		<div id="logo">
			<!-- insertion logo -->
			<img id="logo2" src="<?= $this->assetUrl('img/logo.png') ?>" alt="logo">
		</div>

		<div id="infoUser">
			<!-- affichage du pseudo -->
			<div><?= $_SESSION['user']['login'] ?></div>
			<!-- affichage de l'xp -->
			<div>Level <?= $_SESSION['user']['level'] ?></div>
			<!-- affichage des po -->
			<div id="money"><?= $_SESSION['user']['money'] ?> PO</div>
			<!-- bouton déconnexion-->
			<a href="<?= $this->url('game_log_out')?>">Déconnexion</a>
		</div>
		<div class="clearfix"></div>
		<!-- navigation -->
		<nav>
			<ul>
				<li class="viber"><a href="<?= $this->url('game_farm')?>" id="farm">ferme</a></li>
				<li class="viber"><a href="<?= $this->url('game_building')?>">bâtiments</a></li>
				<li class="viber"><a href="<?= $this->url('game_animals')?>" id="animals">animaux</a></li>
				<li class="viber"><a href="<?= $this->url('game_field')?>">cultures</a></li>
				<li class="viber"><a href="<?= $this->url('game_products')?>">produits</a></li>
				<li class="viber"><a href="<?= $this->url('game_market')?>" id="market">marché</a></li>
				<div class="clearfix"></div>
			</ul>
		</nav>
	</div>
</header>

<main>
	<div class="container">
		<section id="navLeft">
			<!-- Section création -->
			<article id="creations">
				<div id="dialog"></div>
				<div id="listCreations"></div>
			</article>
			
			<!-- Section mes produits -->
			<article id="products">
				<div id="listProducts"></div>
			</article>
			
			<!-- Section tchat -->
			<article>
				<h4>le tchat</h4>
				<!-- Le tchat -->
				<div id="chat">
					<div id="chatDisplay">

					</div>
					<div id="chatboard">
						<textarea name="message" id="message" placeholder="Message" cols="20" rows="2"></textarea>
						<button id="sendMessage">Envoyer</button>
					</div>
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
	<a href="mailto: contact@lornfarm.com">Des questions ?</a>
</footer>
</body>
</html>