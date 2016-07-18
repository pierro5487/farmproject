<?php $this->layout('layout',['title'=>'Productions'])?>



<?php $this->start('main_content'); ?>
<?php
foreach ($products as $product){
    ?>
    <article class="listing">
        <div class="avatar"><img src="<?= $this->assetUrl($product['image_path'])?>"/></div>
        <div class="information">
            <ul>
                <li>Produit: <?= $product['name']?></li>
                <li>Quantité: <?= $product['quantity'].' '.$product['unity']?></li>
                <li>Prix de vente unitaire: <?= $product['price_sale']?> PO</li>
                <li>Prix de vente: <?= $product['price_sale']*$product['quantity']?> PO</li>
            </ul>
            <button class="deleteProduct" value="<?= $product['idStock'] ?>">Vendre</button>
        </div>
    </article>
    <?php
}
?>
<?php $this->stop('main_content'); ?>

