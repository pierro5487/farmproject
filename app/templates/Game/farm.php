<?php $this->layout('layout', ['title' => 'Récapitulatif de votre ferme']) ?>

<?php $this->start('main_content') ?>

    <div class="left">login:</div><div class="right"><?= $userInformations['login'] ?></div>
    <div class="left">Niveau:</div><div class="right"><?= $userInformations['level'] ?></div>
    <div class="left">Money:</div><div class="right"><?= $userInformations['money']."po" ?></div>

    <?php $timeStampCreated = strtotime($userInformations['date_created']) ?>
    <?= "<br>Votre ferme à ".round(((time()- $timeStampCreated)/60)/60)." heures" ?>


        <?php foreach ($allUserFarmInformations as $value => $key) : ?>
            <?php
                if($value == 'buildings'){
                    $maxAnimals = $key['maxQuantity'];
                    echo "<h2>Vos batiments:</h2>".$key['count']." ".mb_strtolower($key['name'], 'utf8')."(s)";
                }
                else if($value == 'animals'){
                    echo "<h2>Vos animaux:</h2>".$key['count']."/".$maxAnimals." ".mb_strtolower($key['name'], 'utf8')."(s)";
                }
                else if($value == 'products'){
                    echo "<h2>Vos produits:</h2>".$key['count']." ".mb_strtolower($key['name'], 'utf8')."(s)";
                }
                else if($value == 'fields'){
                    echo "<h2>Vos champs:</h2>".$key['count']." champs de ".mb_strtolower($key['name'], 'utf8')."(s)";
                }
                else if($value == 'fields'){
                    echo "<h2>Vos champs:</h2>".$key['count']." ".mb_strtolower($key['name'], 'utf8')."(s)";
                }
            ?>
        <?php endforeach; ?>

<?php echo "<br><br><br>"; var_dump($allUserFarmInformations) ?>
<?php $this->stop('main_content') ?>