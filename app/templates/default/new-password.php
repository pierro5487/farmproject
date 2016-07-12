<!doctype html>
<html lang="fr">
<head>
    <title>Insertion d'un utilisateur</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= $this->assetUrl('css/inscription.styles.css')?>">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />
</head>
<body>
    <main>
        <?php
        if(!isset($validationPassword)){
        ?>
        <div class="container">
            <div class="box">
                <h1>veuillez entrer un nouveau mot de passe</h1>
                <form action="#" method="POST">
                    <div class="field">
                        <input type="password" name="password1"  placeholder="nouveau mot de passe"><br>
                        <?php
                        if (isset($errors['pass1']['empty'])||isset($errors['pass1']['size'])) {
                            echo '<div class="error">Entrez un password compris entre 8 et 20 caractères</div>';
                        }
                        ?>
                    </div>
                    <div class="field">
                        <input type="password" name="password2"  placeholder="confirmation mot de passe"><br>
                        <?php
                        if (isset($errors['pass2']['notSame'])||isset($errors['pass2']['empty'])) {
                            echo '<div class="error">Entrez un password identique au premier</div>';
                        }
                        ?>
                    </div>
                    <div class="field">
                        <button type="submit" name="new-password">Ajouter un utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
        <?php }else{ ?>
        <div class="container">
            <div class="box">
                <p>Votre mot de passe à été remplacé</p>
                <a href="<?= $this->url('home');?>">Retour à l'acceuil</a>
            </div>
        </div>
        <?php } ?>
    </main>
</body>
</html>