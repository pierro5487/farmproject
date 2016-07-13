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
            </ul>
            <button class="deleteAnimal">Vendre</button>
        </div>
    </article>
    <?php
}
?>