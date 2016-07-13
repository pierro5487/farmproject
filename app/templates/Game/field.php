<?php $this->layout('layout',['title'=>'animaux'])?>

<?php $this->start('main_content'); ?>

<fieldset disabled>
    <!-- affichage des champs sous forme de select-->
    <?php foreach($fields as $field) : ?>
    Champ:
    <select name="field" id="field">
        <option value=""><?= $field['id'] ?></option>
    </select>

    <!-- Lien pour afficher le détail du champ-->
    <a href="#">Voir le champ</a>
    <?php endforeach; ?>

</fieldset>

<!-- Affichage du détail -->
<?php
foreach ($fields as $field2){
    ?>
    <article class="listing">
        <div class="avatar"><img src="<?= $this->assetUrl($field2['image'])?>"/></div>
        <div class="information">
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
