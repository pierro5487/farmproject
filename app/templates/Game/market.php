<?php $this->layout('layout',['title'=>'Marché'])?>

<?php $this->start('main_content'); ?>
<!--    select pour afficher le animaux qu'on veut voir-->
Animaux:
<select name="animal" id="market_select">
    <option value="*">Tous</option>
    <?php
    $oldSpecies = '';
    $inOptGroup = false;
    foreach($animalsList as $animal) {
        if($animal['name'] !== $oldSpecies) {
            echo '<option value="'.$animal['name'].'">'.$animal['name'].'</option>';
            $oldSpecies = $animal['name'];
        }
    }
    ?>
</select>

<div id="marketList">
<?php
foreach ($animalsList as $animal){
    ?>
    <article id="m_<?= $animal['idMarket']?>" specieName="<?=$animal['name'] ?>" class="listing">
        <div class="avatar"><img src="<?= $this->assetUrl($animal['image_path'])?>"/></div>
        <div class="information">
            <ul>
                <li>Espece: <?= $animal['name']?></li>
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
                        echo '<p>Plus de place!!!</p>';
                    }else if($animal['price_purchase']>$_SESSION['user']['money']){
                        echo '<p>Pas assez de monnaie!!!</p>';
                    }
                ?>
        </div>
    </article>
    <?php
}
?>
</div>
<?php $this->stop('main_content'); ?>
