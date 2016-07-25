<h4>mes produits</h4>
<h6>Animalier</h6>
<ul>
    <?php
    foreach($products as $product){
        echo '<li><p>'.$product['productName'].' : '.$product['nb'].' '.$product['unity'];
        if($product['nb']>1){
            echo 's';
        }
        echo '</p>';
        echo '<p>'.$product['nb'].'/'.$product['nbMax'].'</p>';
        echo '<p><progress value="'.$product['nb'].'" max="'.$product['nbMax'].'">loading</progress></p>';
        echo '</li>';
    }
    ?>
    <a href="<?= $this->url('harvest')?>">Récolter</a>
</ul>
<h6>Céréalier</h6>
<?php
    if($fieldsReady!=0){
        echo '<p class="fieldsReady">Vous avez '.$fieldsReady.' champs prêt(s) à récolter</p>';
    }else{
        echo '<p class="fieldsReady">Vous n\'avez aucun champ prêt à récolter</p>';
    }
?>

