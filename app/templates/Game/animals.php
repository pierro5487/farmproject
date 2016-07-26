<?php $this->layout('layout',['title'=>'animaux'])?>


<?php $this->start('main_content'); ?>

<!--    select pour afficher le animaux qu'on veut voir-->
Animaux:
<select name="animal" id="animal">
    <option value="*">Tous</option>
    <?php
    $oldSpecies = '';
    $inOptGroup = false;
    foreach($animals as $animal) {
        if($animal['name_species'] !== $oldSpecies) {
            // Nouvel animal
            if($inOptGroup)
                echo '</optgroup>';
            echo '<optgroup label="' . $animal['name_species'] . '">';
            $inOptGroup = true;
        }
        echo '<option value="'.$animal['idAnimal'].'">'.$animal['nameAnimal'].'</option>';
        $oldSpecies = $animal['name_species'];
    }
    echo '</optgroup>';
    ?>
</select>

<?php
    foreach ($animals as $animal){
            ?>
            <article id="a_<?= $animal['idAnimal']?>" class="listing">
                <div class="avatar"><img src="<?= $this->assetUrl($animal['image_path'])?>"/></div>
                <div class="information">
                    <ul>
                        <li>Espece: <?= $animal['name_species']?></li>
                        <li>Nom: <?= $animal['nameAnimal']?></li>
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
    if(!isset($animal)){
        echo "<div id=\"empty\">Oups .. Plus d'animaux dans ta ferme !<br> As-tu étais faire un tour au <a href=\"".$this->url('game_market')."\">marché</a> ?</div>";
    }
?>
<?php $this->stop('main_content'); ?>

