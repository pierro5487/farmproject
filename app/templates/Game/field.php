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
<div id="fieldsList">
    <?php foreach ($fields as $field2) : ?>
        <article id="f_<?= $field2['id']?>" class="listingField">
            <div class="avatarField"><img src="<?= $this->assetUrl($field2['image'])?>"/></div>
             <div class="informationField">
                <ul>
                    <li>Plantation: <?= $field2['nameCereals']?></li>
                </ul>
                <progress value="<?= $field2['fieldValue'] ?>" max="100">loading</progress>
                <button class="harvest"<?php if($field2['fieldValue']<100){ echo 'disabled';} ?>>Récolter</button>
             </div>
        </article>
    <?php endforeach ?>
</div>

<?php
    if(!isset($field)){
        echo "<div id=\"empty\">Oups .. Pas de champs en location !<br><br><- C'est juste à gauche !</div>";
   }
?>

<?php $this->stop('main_content'); ?>
