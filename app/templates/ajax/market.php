<h4>Champs</h4>
    <ul>
        <?php foreach ($species as $specie) : ?>
    <?php
    if($specie['name']){
        echo "<li>".$specie['name']." ";
        if($user['level'] >= $specie['level_access']){
            if($specie['price_purchase'] <= $user['money']){
                echo "<div class='green'>".$specie['price_purchase']."</div>";
                echo "<button data-creationId2=\"" . $specie['id'] . "\" class=\"creations2\" id=\"".$specie["name"]."Creations\">+</button></li>";
            }
            else{
                echo "<div class='red'>".$specie['price_purchase']."</div>";
                echo "<button id='noBuildingCreations'>x</button></li>";
            }
        }
        else{
            echo "<i class=\"red\"> (LvL insuffisant)</i>";
        }
    }
    ?>
<?php endforeach; ?>
</ul>
<div class="clearfix"></div>