<h5>Creations</h5>
    <h4>Bâtiments</h4>
        <ul>
        <?php foreach ($creations as $creation) : ?>
            <?php
                if($creation['name']){
                    echo "<li>".$creation['name']." ";
                    if($user['level'] >= $creation['level_access']){
                        if($creation['price_construction'] <= $user['money']){
                            echo "<div class='green'>".$creation['price_construction']."</div>";
                            echo "<button data-creationId=\"" . $creation['id'] . "\" class=\"creations\" id=\"".$creation["name"]."Creations\">+</button></li>";
                        }
                        else{
                            echo "<div class='red'>".$creation['price_construction']."</div>";
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

    <h4>Champs</h4>
    <ul>
        <?php foreach ($creations2 as $creation) : ?>
            <?php
            if($creation['name']){
                echo "<li>".$creation['name']." ";
                if($user['level'] >= $creation['level_access']){
                    if($creation['price_purchase'] <= $user['money']){
                        echo "<div class='green'>".$creation['price_purchase']."</div>";
                        echo "<button data-creationId2=\"" . $creation['id'] . "\" class=\"creations2\" id=\"".$creation["name"]."Creations\">+</button></li>";
                    }
                    else{
                        echo "<div class='red'>".$creation['price_purchase']."</div>";
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

