<?php $this->layout('layout',['title'=>'Creations'])?>

<?php $this->start('main_content'); ?>
    <article>
        <h5>Creations</h5>
        <h4>Bâtiments</h4>

        <ul>
            <?php foreach ($creations as $creation) : ?>
                <li><?= $creation['name'] ?><?= "<h6>".$creation['price_construction']."</h6><button class=\"creations\" id=".$creation['name']."Creations\">+</button></li>" ?>
            <?php endforeach; ?>
        </ul>

        <h4>Champs</h4>
        <ul>
            <li><a href="#">Champs1</a></li>
            <li><a href="#">Champs2</a></li>
            <li><a href="#">Champs3</a></li>
        </ul>
        <div class="clearfix"></div>
    </article>
<?php $this->stop('main_content'); ?>

