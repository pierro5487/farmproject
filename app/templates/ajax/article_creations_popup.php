
<!-- Affichage des détails de l'achat d'un bâtiment-->

<article id="b_<?= $typeBuilding['id']?>" class="listingBuilding">
    <div class="avatarBuilding"><img src="<?= $this->assetUrl($typeBuilding['image_path'])?>"/></div>
    <div class="informationBuilding">
        <ul>
            <li class='name'>Type: <span><?= $typeBuilding['name']?></span></li>
            <li class='price'>Cout: <span><?= $typeBuilding['price_construction']?></span></li>
        </ul>
        <button class="addBuilding" id="<?= $typeBuilding['id']?>" >Acheter</button>
    </div>
    <script>

        var typeBuildingid = "<?= $typeBuilding['id'] ?>";

    </script>
</article>