<?php $this->layout('layout', ['title' => 'Récapitulatif de votre ferme']) ?>

<?php $this->start('main_content') ?>
    <div id="farmcontenant">
        <div id="farmcontenu">
            <div class="container">
                <div class="left">Expérience: (<?= $levelUpInformations['current_xp'] ?>/<?= $levelUpInformations['max_experience'] ?>)</div>
                <div class="right"><progress id="avancement" value="<?= $levelUpInformations['current_xp'] ?>" max="<?= $levelUpInformations['max_experience'] ?>"></progress></div>
                <div class="left">Xp total: <?= $userInformations['experience']."xp" ?></div>
                <?php $timeStampCreated = strtotime($userInformations['date_created']) ?><br>
                <?= "<br>Votre ferme a ".round(((time()- $timeStampCreated)/60)/60)." heures" ?>
                <div class="box">
                    <!-- Affichage des informations relatives à la ferme -->
                    <ul>
                        <?php foreach ($allUserFarmInformations as $value => $key) : ?>
                            <?php
    
                            if ($value == 'buildings' && $key != null) {
                                echo "<h2>Vos batiments:</h2>";
                                for ($i = 0; $i< count($key); $i++) {
                                    $name = $key[$i]['name'];
                                    if($key[$i] != $name) {
                                        echo "<li>".$key[$i]['nb_building'] . " " . mb_strtolower($key[$i]['name'], 'utf8') . "(s) (" . $key[$i]['max_quantity']." place(s) max)</li>";
                                    }
                                }
                            }
    
                            else if ($value == 'animals' && $key != null) {
                                echo "<h2>Vos animaux:</h2>";
                                for ($i = 0; $i< count($allNbAnimalsInformations); $i++) {
                                    $name = $key[$i]['name'];
                                    if($key[$i] != $name) {
                                        echo "<li>".$allNbAnimalsInformations[$i]['nb_animals'] . "/" . $allUserFarmInformations['buildings'][$i]['max_quantity'] . " " . mb_strtolower($allNbAnimalsInformations[$i]['name'], 'utf8') . "(s)</li>";
                                    }
                                }
                            }
    
                            else if ($value == 'fields' && $key != null) {
                                echo "<h2>Vos champs:</h2>";
                                for ($i = 0; $i< count($key); $i++) {
                                    $name = $key[$i]['name'];
                                    if($key[$i] != $name) {
                                        echo "<li>" . $key[$i]['nb_field'] . " champ(s)";
                                        if (!empty($key[$i]['name'])) echo " de " . mb_strtolower($key[$i]['name'], 'utf8') . "(s)</li>";
                                    }
                                }
                            }
                            else if ($value == 'products' && $key != null) {
                                echo "<h2>Vos produits:</h2>";
                                for ($i = 0; $i< count($key); $i++) {
                                    $name = $key[$i]['name'];
                                    if($key[$i] != $name) {
                                        echo "<li>" . $key[$i]['quantity'] . " unité(s)";
                                        if (!empty($key[$i]['name'])) echo " de " . mb_strtolower($key[$i]['name'], 'utf8') . "(s)</li>";
                                    }
                                }
                            }
                            ?>
                        <?php endforeach; ?>
                        <!-- Fin affichage des informations relatives à la ferme -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $this->stop('main_content') ?>