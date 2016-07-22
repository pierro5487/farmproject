<h5>mes produits</h5>
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
</ul>
<h6>Céréalier</h6>
<?php
    if($fieldsReady!=0){
        echo '<p>Vous avez '.$fieldsReady.' champs prêt à récolter</p>';
    }else{
        echo '<p>Vous n\'avez aucun champ prêt à récolter</p>';
    }
?>