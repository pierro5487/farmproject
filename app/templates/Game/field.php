<?php $this->layout('layout',['title'=>'champs'])?>

<?php $this->start('main_content'); ?>

    <!-- affichage des champs sous forme de select-->
    Champs:
    <select name="field" id="field">
        <option value="*">Tous</option>
        <?php $cpt = 1 ?>
        <?php foreach($fields as $field) : ?>
            <option value="<?= $field['id']?>"><?= "n°" . $cpt ?></option>
        <?php $cpt++ ?>
        <?php endforeach; ?>
    </select>

    <!-- Affichage du détail -->
<div id="fieldsList">
    <?php foreach ($fields as $field) : ?>
        <article id="f_<?= $field['id']?>" class="listingField">
            <div class="avatarField"><img src="<?= $this->assetUrl($field['image'])?>"/></div>
             <div class="informationField">
                <ul>
                    <li>Plantation: <?= $field['nameCereals']?></li>
                </ul>
                <progress value="<?= $field['fieldValue'] ?>" max="100">loading</progress>
                <button class="harvest"
                    <?php
                        if($field['fieldValue']<100){
                            echo 'disabled';
                        }
                    ?>
                >
                    <?php
                    if($field['fieldValue']<100){
                        echo 'en cours..'.$field['fieldValue'].'%';
                    }else{
                        echo 'Récolter';
                    }
                    ?>
                </button>
             </div>
        </article>
    <?php endforeach ?>
</div>
<?php $this->stop('main_content'); ?>
