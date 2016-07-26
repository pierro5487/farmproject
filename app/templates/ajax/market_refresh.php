
<?php
foreach ($animalsList as $animal){
    ?>
    <article id="a_<?= $animal['idMarket']?>" specieName="<?=$animal['name'] ?>" class="listing">
        <div class="avatar"><img src="<?= $this->assetUrl($animal['image_path'])?>"/></div>
        <div class="information">
            <ul>
                <li>Espece: <?= $animal['name']?></li>
                <li>Nom:<?= $animal['name'].$animal['idMarket']?></li>
                <li>Poids: <?= $animal['weight']?> Kgs</li>
                <li>Prix d'achat: <?= $animal['price_purchase']?> PO</li>
            </ul>
            <button class="buyAnimal" value="<?= $animal['idMarket'] ?>"
                <?php
                if(!$animal['location'] || $animal['price_purchase']>$_SESSION['user']['money']){
                    echo 'disabled';
                }
                ?>
            >Acheter</button>
            <?php
            if(!$animal['location']){
                echo '<p>Pas assez de place !</p>';
            }else if($animal['price_purchase']>$_SESSION['user']['money']){
                echo '<p>Pas assez de monnaie !</p>';
            }
            ?>
        </div>
    </article>
    <?php
}
?>