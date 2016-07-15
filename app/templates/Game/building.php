<?php $this->layout('layout',['title'=>'batiments'])?>

<?php $this->start('main_content'); ?>

    <!--    select pour afficher le bâtiment qu'on veut voir-->
    Bâtiments:
    <select name="building" id="building multiple">
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
<!---->
<!--    --><?php //foreach($buildings as $building) : ?>
<!--        <option value="">--><?//= $building['id'] ?><!--</option>-->
<!--    --><?php //endforeach ?>
    </select>

    <a href="#">Voir le bâtiment</a>

<?php foreach($buildings as $building) : ?>
    <!-- Lien pour afficher le détail du bâtiment-->
        <article class="listingBuilding">
           <div class="avatarBuilding"><img src="<?= $this->assetUrl($building['image_path'])?>"/></div>
            <div class="informationBuilding">
               <ul>
                   <li>Type: <?= $building['name']?></li>
                   <li>Niveau: <?= $building['level']?></li>
                   <li>Nombre d'animaux maximum: <?= $building['max_quantity'] ?></li>
                   <li>Date de création: <?= $building['date'] ?></li>
                   <li>Niveau d'accès: <?= $building['level_access']?></li>
                   <li>Coût de l'amélioration: <?= $building['price_improvement']?></li>
               </ul>
              <button class="improvement">Amélioration</button>
           </div>
        </article>
<?php endforeach ?>

<?php $this->stop('main_content'); ?>