<!doctype html>
<html lang="fr">
<head>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=yes">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">

    <title>Oppppssss</title>
</head>
<body id="error404">
    <div class="container">
        <section id="errorSection">
            <h1 id="errorTitle">Oooops! Tu as du te tromper!</h1>
            <p class="errorP">Essaie voir de <a href="<?= $this->url('home') ?>"><strong>cliquer ici</strong></a>, ça pourrait t'aider à retrouver une page plus amusante! </p>
            <div class="errorDiv"><p id="errorParagraphe" class="errorP">L'équipe de Lor'N Farm</p></div>
        </section>
    </div>
</body>
</html>

