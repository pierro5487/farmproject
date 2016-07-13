<?php $this->layout('layout', ['title' => 'Récapitulatif de votre ferme']) ?>

<?php $this->start('main_content') ?>
    <div class="container">

        <div class="left">login:</div><div class="right"><?= $userInformations['login'] ?></div>
        <div class="left">Niveau:</div><div class="right"><?= $userInformations['level'] ?></div>
        <div class="left">Money:</div><div class="right"><?= $userInformations['money']."po" ?></div>

        <?php $timeStampCreated = strtotime($userInformations['date_created']) ?>
        <?= "<br>Votre ferme à ".round(((time()- $timeStampCreated)/60)/60)." heures" ?>
            <div class="box">
            <ul>
            <?php foreach ($allUserFarmInformations as $value => $key) : ?>
                <?php
                        if ($value == 'buildings') {
                            echo "<h2>Vos batiments:</h2>";
                            for ($i = 0; $i< count($key); $i++) {
                                $name = $key[$i]['name'];
                                if($key[$i] != $name) {
                                    echo "<li>".$allUserFarmInformations['buildings'][$i]['nb_building'] . " " . mb_strtolower($allUserFarmInformations['buildings'][$i]['name'], 'utf8') . "(s) (" . $allUserFarmInformations['buildings'][$i]['max_quantity']*$allUserFarmInformations['buildings'][$i]['nb_building']." place(s) max)</li>";
                                }
                            }
                        }
                        else if ($value == 'animals') {
                            echo "<h2>Vos animaux:</h2>";
                            for ($i = 0; $i< count($allNbAnimalsInformations); $i++) {
                                $name = $key[$i]['name'];
                                if($key[$i] != $name) {
                                    echo "<li>" . $allNbAnimalsInformations[$i]['nb_animals'] . "/" . $allUserFarmInformations['buildings'][$i]['max_quantity'] . " " . mb_strtolower($allNbAnimalsInformations[$i]['name'], 'utf8') . "(s)</li>";
                                }
                            }
                        }
                        else if ($value == 'fields') {
                            echo "<h2>Vos champs:</h2>";
                            for ($i = 0; $i< count($key); $i++) {
                                /*var_dump($key);*/
                                $name = $key[$i]['name'];
                                if($key[$i] != $name) {
                                    echo "<li>" . $allUserFarmInformations['fields'][$i]['nb_field'] . " champ(s)";
                                    if (!empty($key[$i]['name'])) echo " de " . mb_strtolower($allUserFarmInformations['fields'][$i]['name'], 'utf8') . "(s)</li>";
                                }
                            }
                        }
                        else if ($value == 'products') {
                            echo "<h2>Vos produits:</h2>";
                            for ($i = 0; $i< count($key); $i++) {
                                $name = $key[$i]['name'];
                                if($key[$i] != $name) {
                                    echo "<li>" . $allUserFarmInformations['products'][$i]['quantity'] . " unité(s)";
                                    if (!empty($key[$i]['name'])) echo " de " . mb_strtolower($allUserFarmInformations['products'][$i]['name'], 'utf8') . "(s)</li>";
                                }
                            }
                        }

                ?>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php $this->stop('main_content') ?>