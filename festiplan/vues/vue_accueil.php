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
                <button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button>
            </div>
        </div>
    </div>
</header>
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
                    echo $festival['nom'];
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
        <a href="/festiplan?controller=Spectacle"><button type="submit" class="btn btn-gris">Créer un spectacle</button></a>
        <a href="/festiplan?controller=Festival"><button type="submit" class="btn btn-bleu">Créer un festival</button></a>
        <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion"><button type="submit" class="btn btn-danger">Deconnexion</button></a>
        <a href="/festiplan?controller=Accueil&action=<?php if ($afficher) {echo 'voirFestival';} else { echo 'VoirSpectacle';}?>"><button type="submit" class="btn btn-danger"><?php if ($afficher) {echo 'Voir mes festivals';} else { echo 'Voir mes spectacles';}?></button></a>
    </div>
</body>
</html>