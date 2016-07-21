
<!-- Affichage du détail -->
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