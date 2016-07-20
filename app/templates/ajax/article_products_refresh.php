<h5>mes produits</h5>
<ul>
    <?php
    foreach($products as $product){
        echo '<li><p>'.$product['productName'].' : '.$product['nb'].' '.$product['unity'];
        if($product['nb']>1){
            echo 's';
        }
        echo '</p>';
        echo '<p>'.$product['nb'].'/'.$product['nbMax'].'</p>';
        echo '<p><progress id="avancement" value="'.$product['nb'].'" max="'.$product['nbMax'].'">loading</progress></p>';
        echo '</li>';
    }
    ?>
</ul>