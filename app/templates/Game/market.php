<?php $this->layout('layout',['title'=>'Marché'])?>

<?php $this->start('main_content'); ?>
<?php
foreach ($animalsList as $animal){
    ?>
    <article id="a_<?= $animal['idMarket']?>" class="listing">
        <div class="avatar"><img src="<?= $this->assetUrl($animal['image_path'])?>"/></div>
        <div class="information">
            <ul>
                <li>Espece: <?= $animal['name']?></li>
                <li>Poids: <?= $animal['weight']?> Kgs</li>
                <li>Prix d'achat: <?= $animal['price_purchase']?> PO</li>
            </ul>
            <button class="purchaseAnimal" value="<?= $animal['idMarket'] ?>">Acheter</button>
        </div>
    </article>
    <?php
}
?>
<?php $this->stop('main_content'); ?>
