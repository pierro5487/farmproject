<html>
    <head>
        <title>Insertion d'un utilisateur</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= $this->assetUrl('css/inscription.styles.css')?>">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />
    </head>
    <body>
        <?php
        if (!empty($_POST) && empty($errors)) :
            ?>
            <!--On ne fait rien car le controller s'en charge-->
            <?php
        else :
        ?>
        <main>
            <div class="container">
                <div class="box">
                    <h1>Inscription</h1>
                    <form action="#" method="POST">
                        <div class="field">
                            <input type="text" name="pseudo" value="<?php if (isset($_POST['pseudo'])) echo $_POST['pseudo'] ?>" placeholder="Pseudo"><br>
                            <?php
                            if (isset($errors['pseudo'])) :
                                if (isset($errors['pseudo']['empty'])) :
                                    ?>
                                    <div class="error">Entrez un pseudo</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>" placeholder="E-mail"><br>
                            <?php
                            if (isset($errors['email'])) :
                                if (isset($errors['email']['empty'])) :
                                    ?>
                                    <div class="error">Le mail doit être rempli</div>
                                    <?php
                                endif;
                                if (isset($errors['email']['invalid'])) :
                                    ?>
                                    <div class="error">L'email n'est pas valide</div>
                                    <?php
                                endif;
                                if (isset($errors['email']['exists'])) :
                                    ?>
                                    <div class="error">Un compte est déjà enregistré avec cette adresse</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <input type="password" name="pass1" placeholder="Mot de passe"><br>
                            <?php
                            if (isset($errors['pass1'])) :
                                if (isset($errors['pass1']['empty'])) :
                                    ?>
                                    <div class="error">Entrez un mot de passe</div>
                                    <?php
                                endif;
                                if (isset($errors['pass1']['size'])) :
                                    ?>
                                    <div class="error">Le mot de passe doit comprendre entre 8 et 30 caractères</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <input type="password" name="pass2" placeholder="Confirmation"><br>
                            <?php
                            if (isset($errors['pass2'])) :
                                if (isset($errors['pass2']['empty'])) :
                                    ?>
                                    <div class="error">Confirmez le mot de passe</div>
                                    <?php
                                endif;
                                if (isset($errors['pass2']['different'])) :
                                    ?>
                                    <div class="error">Les mots de passe ne correspondent pas</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <input type="text" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname'] ?>" placeholder="Nom de famille"><br>
                            <?php
                            if (isset($errors['lastname'])) :
                                if (isset($errors['lastname']['empty'])) :
                                    ?>
                                    <div class="error">Entrez votre nom</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <input type="text" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname'] ?>" placeholder="Prénom"><br>
                            <?php
                            if (isset($errors['firstname'])) :
                                if (isset($errors['firstname']['empty'])) :
                                    ?>
                                    <div class="error">Entrez votre prénom</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <button type="submit" name="save_user">Ajouter un utilisateur</button>
                        </div>
                    </form>                    
                </div>                 
            </div>
        <?php endif; ?>
        </main>
    </body>
</html>