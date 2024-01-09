<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['utilisateur_connecte']) || $_SESSION['utilisateur_connecte'] == false) {
    header("Location: ../index.php");
}
?>

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
    <div class="container-fluid header">
        <div class="row">
            <div class="col-2">
                <a href="index.php">
                    <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
            <div class="col-8">
                <h2 class="texteCentre blanc bas"><?php if ($afficher) {echo 'Mes spectacles';} else { echo 'Mes festivals';}?></h2>
            </div>
            <div class="col-2">
                <a href="/festiplan?controller=UtilisateurCompte&action=pageProfil"><button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button></a>
            </div>
        </div>
    </div>
</header>
<body class="body-blanc">
    <div class="container-fluid">
    <?php
        // Affichage de la liste des spectacles
        if ($afficher) {
            while ($listeSpectacle = $mesSpectacles->fetch()) {
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="centre">
                            <div class='cadreFestival'>
                                <?php
                                    $idSpectacle = $listeSpectacle['idSpectacle'];
                                    echo $listeSpectacle['titre'];
                                ?>
                                <a href="/festiplan?controller=Spectacle&action=afficherSpectacle&idSpectacle=<?php echo $idSpectacle;?>"><button type="submit" class="btn fondBleu">Modifier le Spectacle</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            //affichage de la liste des festivals
            while ($festival = $mesFestivals->fetch()) {
                $idFestival = $festival['idFestival'];
            ?>  
                <div class="row">
                    <div class="col-12">
                        <a href='/festiplan?controller=Grij&idFestival=<?php echo $idFestival;?>'>
                            <div class="centre">  
                                <div class='cadreFestival'>
                                    <?php
                                    echo $festival['titre']."<br>";
                                    echo $festival['nom'];
                                    ?>
                                    <a href="/festiplan?controller=Festival&action=afficherFestival&idFestival=<?php echo $idFestival;?>"><button type="submit" class="btn fondBleu">Modifier le Festival</button></a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <br>
            <?php
            }
       }
    ?>
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-6 col-md-3">
                <a href="/festiplan?controller=Spectacle"><button type="submit" class="btn btnModif fondVert">Créer un spectacle</button></a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/festiplan?controller=Festival"><button type="submit" class="btn btnModif fondBleu">Créer un festival</button></a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion"><button type="submit" class="btn btnModif fondRouge">Deconnexion</button></a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/festiplan?controller=Accueil&action=<?php if ($afficher) {echo 'voirFestival';} else { echo 'VoirSpectacle';}?>"><button type="submit" class="btn btnModif fondGris"><?php if ($afficher) {echo 'Voir mes festivals';} else { echo 'Voir mes spectacles';}?></button></a>
            </div>
        </div>
    </div>
</body>
</html>