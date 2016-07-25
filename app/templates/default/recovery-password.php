<!doctype html>
<html lang="fr">
<html>
<head>
    <title>Insertion d'un utilisateur</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= $this->assetUrl('css/inscription.styles.css')?>">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />
</head>
<body>
<?php
    if(isset($_POST['recovery'])&& !isset($errors)){
        /*On ne fait rien car le controller s'en charge*/
    }else{
    //j'affiche formulaire
?>
<main>
    <div class="container">
        <div class="box">
            <h1>J'ai perdu mon mot de passe</h1>
            <form action="#" method="POST">
                <div class="field">
                    <input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>" placeholder="email"><br>
                    <?php
                        if (isset($errors['email']['empty'])||isset($errors['email']['invalid'])) {
                            echo '<div class="error">Entrez un email valide</div>';
                        }else if(isset($errors['email']['noExist'])){
                            echo '<div class="error">Aucun compte n\'est enregistré sous cette email</div>';
                        }
                    ?>
                </div>
                <div class="field">
                    <button type="submit" name="recovery">Ajouter un utilisateur</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php } ?>
</body>
</html>