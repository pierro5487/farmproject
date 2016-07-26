<?php $this->layout('layout',['title'=>''])?>

<?php $this->start('main_content'); ?>

<!--    select pour afficher la production qu'on veut voir-->
Produits:
<select name="product" id="productSelect">
    <option value="*">Tous</option>
    <?php
    foreach($products as $product) {
        echo '<option value="'.$product['idStock'].'">'. $product['name'].'</option>';
    }
    ?>
</select>

<?php
foreach ($products as $product){
    ?>
    <article id="p_<?= $product['idStock']?>" class="listing">
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
if(!isset($product)){
    echo "<div id=\"empty\">Tu n'as pas de produit pour l'instant ..</div>";
}
?>
<?php $this->stop('main_content'); ?>

