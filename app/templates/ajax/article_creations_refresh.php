<?php /*print_r($creations); */?>
<h5>Creations</h5>
    <h4>Bâtiments</h4>
        <ul>
        <?php foreach ($creations as $creation) : ?>
            <?php
                if($user['level'] >= $creation['level_access'] && $creation['name']){
                    echo "<li>".$creation['name']." ";
                    if($creation['price_construction'] <= $user['money']){
                        echo "<div class='green'>".$creation['price_construction']."</div>";
                        echo "<button data-creationId=\"" . $creation['id'] . "\" class=\"creations\" id=\"".$creation["name"]."Creations\">+</button></li>";
                    }
                    else{
                        echo "<div class='red'>".$creation['price_construction']."</div>";
                        echo "<button id='noBuildingCreations'>X</button></li>";
                    }
                }
            ?>
        <?php endforeach; ?>
        </ul>

    <h4>Champs</h4>
    <ul>
        <li><a href="#">Champs1</a></li>
        <li><a href="#">Champs2</a></li>
        <li><a href="#">Champs3</a></li>
    </ul>
    <div class="clearfix"></div>

