<?php $this->layout('layout',['title'=>'champs'])?>

<?php $this->start('main_content'); ?>

    <!-- affichage des champs sous forme de select-->
    Champs:
    <select name="field" id="field">
        <option value="*">Tous</option>
        <?php $cpt = 1 ?>
        <?php foreach($fields as $field) : ?>
            <option value="<?= $field['id']?>"><?= "n°" . $cpt ?></option>
        <?php $cpt++ ?>
        <?php endforeach; ?>
    </select>

    <!-- Affichage du détail -->
    <?php foreach ($fields as $field2) : ?>
        <article id="f_<?= $field2['id']?>" class="listingField">
            <div class="avatarField"><img src="<?= $this->assetUrl($field2['image'])?>"/></div>
             <div class="informationField">
                <ul>
                    <li>Plantation: <?= $field2['nameCereals']?></li>
                </ul>
                <button class="harvest">Récolter</button>
             </div>
        </article>
    <?php endforeach ?>

<?php $this->stop('main_content'); ?>
