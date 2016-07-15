<?php $this->layout('layout',['title'=>'animaux'])?>

<?php $this->start('main_content'); ?>

    <!-- affichage des champs sous forme de select-->
    Champs:
    <select name="field" id="field">
        <?php $cpt = 1 ?>
        <?php foreach($fields as $field) : ?>
        <option value="$field['id']"><?= "n°" . $cpt ?></option>
            <?php $cpt++ ?>
        <?php endforeach; ?>
    </select>

    <!-- Lien pour afficher le détail du champ-->
    <a href="#">Voir le champ</a>

<!-- Affichage du détail -->
<?php
foreach ($fields as $field2){
    ?>
    <article class="listingField">
        <div class="avatarField"><img src="<?= $this->assetUrl($field2['image'])?>"/></div>
        <div class="informationField">
            <ul>
                <li>Champ: <?= $field2['id']?></li>
                <li>Plantation: <?= $field2['nameCereals']?></li>
            </ul>
            <button class="harvest">Récolter</button>
        </div>
    </article>
    <?php
}
?>

<?php $this->stop('main_content'); ?>
