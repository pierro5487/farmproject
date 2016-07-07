<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>
	<!-- fait par pierre en attente attente integration page d'acceuil-->
	<form method="POST" action="#">
		<input type="text" name="login" placeholder="login" />
		<input type="password" name="password" placeholder="password" />
		<input type="submit" name="sendConnexion"/>
	</form>
	<?php 
	if(isset($_POST['sendConnexion'])){
		print_r($_POST);
		}
		?>
<?php $this->stop('main_content') ?>
