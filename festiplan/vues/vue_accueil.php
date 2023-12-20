<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<!--En tête-->
<header>
    <div class="header"><button class="btn btn-primary"><span class="fas fa-solid fa-user"><button></span></div>
</header>
<<<<<<< Updated upstream
<body id="body-blanc">
    <h1> Liste des festivals/spectacles </h1>
    <a href="/festiplan?controller=CreerSpectacle"><button type="submit" class="btn-creer-spectacle">Créer un spectacle</button></a>
    <a href="/festiplan?controller=CreerFestival"><button type="submit" class="btn-bleu">Créer un festival</button></a>
=======
<body class="body-blanc">
    <?php
        // Affichage de la liste des spectacles
        if ($afficher) {
            while ($listeSpectacle = $mesSpectacles->fetch()) 
            {
                ?>
                <div class='cadreFestival'>
                    <?php
                        $idSpectacle = $listeSpectacle['idSpectacle'];
                        echo $listeSpectacle['titre'];
                    ?>
                    <a href="/festiplan?controller=Spectacle&action=afficherSpectacle&idSpectacle=<?php echo $idSpectacle;?>"><button type="submit" class="btn btn-bleu">Modifier le Spectacle</button></a>
                </div>
                <br>
                <?php
            }
        } else {
            //affichage de la liste des festivals
            while ($festival = $mesFestivals->fetch()) {
                $idFestival = $festival['idFestival'];
            ?>  
                <a href='/festiplan?controller=Grij&idFestival=<?php echo $idFestival;?>'>  
                    <div class='cadreFestival'>
                    <?php
                    echo $festival['titre']."<br>";
                    echo $festival['nom']."<br>";
                    ?>
                    <a href="/festiplan?controller=Festival&action=afficherFestival&idFestival=<?php echo $idFestival;?>"><button type="submit" class="btn btn-bleu">Modifier le Festival</button></a>
                    </div>
                </a>
                <br>
                <?php
            }
       }
    ?>
    <div class="footer">
        <div class="row">
            <div class="col-3">
                <a href="/festiplan?controller=Spectacle"><button type="submit" class="btn fondVert">Créer un spectacle</button></a>
            </div>
            <div class="col-3">
                <a href="/festiplan?controller=Festival"><button type="submit" class="btn fondBleu">Créer un festival</button></a>
            </div>
            <div class="col-3">
                <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion"><button type="submit" class="btn fondRouge">Deconnexion</button></a>
            </div>
            <div class="col-3">
                <a href="/festiplan?controller=Accueil&action=<?php if ($afficher) {echo 'voirFestival';} else { echo 'VoirSpectacle';}?>"><button type="submit" class="btn fondGris"><?php if ($afficher) {echo 'Voir mes festivals';} else { echo 'Voir mes spectacles';}?></button></a>
            </div>
        </div>
    </div>
>>>>>>> Stashed changes
</body>
</html>