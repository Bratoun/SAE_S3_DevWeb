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
        <title>Planification</title>
        <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="static/css/index.css"/>
        <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
    </head>
    <header>
        <div class="container-fluid header">
            <div class="row">
                <div class="col-2">
                    <a href="index.php">
                        <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                    </a>
                </div>
                <div class="col-8">
                    <h2 class="texteCentre blanc bas"> Consultation de la planification :</h2>
                </div>
                <div class="col-2 text-right"> <!-- Ajoutez la classe text-right pour aligner à droite -->
                <!-- Icône utilisateur avec menu déroulant -->
                <div class="dropdown">
                    <span class="fas fa-solid fa-user dropdown-btn iconeBlanc icone-user"></span>
                    <div class="dropdown-content">
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageProfil">Profil</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageModifierProfil">Modifier Profil</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageDesinscription">Désinscription</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion">Déconnexion</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </header>
    <body class="body-blanc">
        <div class="container">
            <div class="row">
                <?php
                // Liste des jours du festival
                while($jour = $listeJours->fetch())
                {
                    ?>
                    <div class="col-3">
                        <h3><?php echo $jour['dateJour'];?></h13>
                        <?php
                        // Liste des spetacles du jour du festival
                        $listeTitres = explode(',', $jour['titres']);
                        foreach ($listeTitres as $titreSpectacle){
                            ?>
                            <a href="/festiplan?controller=Grij&action=profilSpectacleJour&idFestival=<?php echo $idFestival;?>&idSpectacle=<?php echo ;?>"><button type="button" class="btn fondGris"><?php echo $titreSpectacle;?></button></a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>