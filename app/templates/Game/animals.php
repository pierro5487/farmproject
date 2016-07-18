<?php $this->layout('layout',['title'=>'animaux'])?>


<?php $this->start('main_content'); ?>
<?php
    foreach ($animals as $animal){
            ?>
            <article class="listing">
                <div class="avatar"><img src="<?= $this->assetUrl($animal['image_path'])?>"/></div>
                <div class="information">
                    <ul>
                        <li>Espece: <?= $animal['name_species']?></li>
                        <li>Nom: <?= $animal['name']?></li>
                        <li>Matricule: <?= $animal['idAnimal'] ?></li>
                        <li>Acheté le: <?= $animal['date_created']?></li>
                        <li>Poids: <?= $animal['weight']?> Kgs</li>
                        <li>Prix vente: <?= $animal['price_sale']?> PO</li>
                    </ul>
                    <button class="deleteAnimal" value="<?= $animal['idAnimal'] ?>">Vendre</button>
                </div>
            </article>
            <?php
    }
?>
<?php $this->stop('main_content'); ?>

