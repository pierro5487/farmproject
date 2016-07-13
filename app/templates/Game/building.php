<?php $this->layout('layout',['title'=>'batiments'])?>

<?php $this->start('main_content'); ?>

<?php
    foreach($buildings as $building) : ?>
        <article class="listing">
            <div class="avatar"><img src="<?= $this->assetUrl($building['image_path'])?>"/></div>
            <div class="information">
                <ul>
                    <li>Type: <?= $building['name']?></li>
                    <li>Niveau: <?= $building['level']?></li>
                    <li>Date de création: <?= $building['date'] ?></li>
                    <li>Niveau d'accès: <?= $building['level_access']?></li>
                </ul>
                <button class="improvement">Amélioration</button>
            </div>
        </article>
    <?php endforeach ?>

<?php $this->stop('main_content'); ?>