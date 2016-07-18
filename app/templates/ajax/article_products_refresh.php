<h5>mes produits</h5>
<ul>
    <?php
    foreach($products as $product){
        echo '<li>'.$product['productName'].' : '.$product['nb'].' '.$product['unity'];
        if($product['nb']>1){
            echo 's';
        }
        echo '</li>';
    }
    ?>
</ul>