
<!-- Affichage des détails de l'achat d'un bâtiment-->

<article id="b_<?= $typeField['id']?>" class="listingField">
    <div class="avatarField"><img src="<?= $this->assetUrl($typeField['image_path'])?>"/></div>
    <div class="informationField">
        <ul>
            <li class='name'>Type: <span><?= $typeField['name']?></span></li>
            <li class='price'>Cout: <span><?= $typeField['price_purchase']?></span></li>
        </ul>
        <button class="addField" id="<?= $typeField['id']?>" >Louer/Semer</button>
    </div>
    <script>

        var typeFieldid = "<?= $typeField['id'] ?>";

    </script>
</article>