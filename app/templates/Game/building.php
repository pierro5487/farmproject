<?php $this->layout('layout',['title'=>'batiments'])?>

<?php $this->start('main_content'); ?>

<!--    select pour afficher le bâtiment qu'on veut voir-->
Bâtiments:
<select name="building" id="building">
    <option value="*">Tous</option>
    <?php
    $cpt = 1;
    $oldBuilding = '';
    $inOptGroup = false;
    foreach($buildings as $building) {
        if($building['name'] !== $oldBuilding) {
            // Nouveau building
            if($inOptGroup)
                echo '</optgroup>';
            echo '<optgroup label="' . $building['name'] . '">';
            $inOptGroup = true;
        }
        echo '<option value="'.$building['id'].'">'."n°" . $cpt.'</option>';
        $cpt++;
        $oldBuilding = $building['name'];
    }
    echo '</optgroup>';
    ?>
</select>

    <!-- Si pas assez de PO on crée une div-->
<div id="errorMoney">Vous n'avez pas assez d'argent</div>

<?php foreach($buildings as $building) : ?>
    <!-- Lien pour afficher le détail du bâtiment-->
    <!-- utilisation d'un préfixe b_ pour être sur que id de l'article soit unique dans toute la pâge -->
    <article id="b_<?= $building['id']?>" class="listingBuilding">
        <div class="avatarBuilding"><img src="<?= $this->assetUrl($building['image_path'])?>"/></div>
        <div class="informationBuilding">
            <ul>
                <li class='name'>Type: <span><?= $building['name']?></span></li>
                <li class='level'>Niveau: <span><?= $building['level']?></span></li>
                <li class='max_quantity'>Nombre d'animaux maximum: <span><?= $building['max_quantity'] ?></span></li>
                <li class='date'>Date de création: <span><?= $building['date'] ?></span></li>
                <li class='level_access'>Niveau d'accès: <span><?= $building['level_access']?></span></li>
                <li class='price_improvement'>Coût de l'amélioration: <span><?= $building['price_improvement']?></span></li>
            </ul>
                <button bid="<?= $building['id']?>" class="improvement"
                    <?php
                        // vérification du niveau de l'utilisateur
                        //possibilité de up le bâtiment qu'une fois tous les x niveau
                        if($_SESSION['user']['level']<($building['level_improvement']*$building['level'])){
                            echo ' disabled';
                        }
                    ?>
                >Améliorer</button>
        </div>
    </article>
<?php endforeach ?>

<?php $this->stop('main_content'); ?>