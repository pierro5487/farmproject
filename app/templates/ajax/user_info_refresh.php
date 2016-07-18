
<!-- affichage du pseudo -->
<div><?= $_SESSION['user']['login'] ?></div>
<!-- affichage de l'xp -->
<div>Level <?= $user['level'] ?></div>
<!-- affichage des po -->
<div><?= $user['money'] ?> PO</div>
<!-- bouton déconnexion-->
<a href="<?= $this->url('game_log_out')?>">Déconnexion</a>
