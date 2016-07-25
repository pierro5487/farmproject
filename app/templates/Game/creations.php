<?php $this->layout('layout',['title'=>'Creations'])?>

<?php $this->start('main_content'); ?>
    <article>
        <h4>Creations</h4>
        <h5>Bâtiments</h5>

        <ul>
            <?php foreach ($creations as $creation) : ?>
                <li><?= $creation['name'] ?><?= "<h6>".$creation['price_construction']."</h6><button class=\"creations\" id=".$creation['name']."Creations\">+</button></li>" ?>
            <?php endforeach; ?>
        </ul>

        <h5>Champs</h5>
        <ul>
            <li><a href="#">Champs1</a></li>
            <li><a href="#">Champs2</a></li>
            <li><a href="#">Champs3</a></li>
        </ul>
        <div class="clearfix"></div>
    </article>
<?php $this->stop('main_content'); ?>

