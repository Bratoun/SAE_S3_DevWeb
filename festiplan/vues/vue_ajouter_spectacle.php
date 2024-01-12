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
    <title>Ajouter des spectacles</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<!--En tête-->
<header>
    <div class="container-fluid header">
        <div class="row">
            <div class="col-3 col-md-2">
                <a href="index.php">
                    <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
            <div class="col-8">
                <h2 class="texteCentre blanc bas">Ajouter des spectacles</h2>
            </div>
            <div class="col-1 col-md-2 text-right"> <!-- Ajoutez la classe text-right pour aligner à droite -->
                <!-- Icône utilisateur avec menu déroulant -->
                <div class="dropdown">
                    <span class="fas fa-solid fa-user dropdown-btn iconeNoir icone-user"></span>
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
    <form action="index.php" method="post">
          
        <input type="hidden" name="controller" value="Festival">
        <input type="hidden" name="action" value="modifierListeSpectacle">
        <input type="hidden" name="idFestival" value="<?php echo $idFestival?>">
        <div class="col-12">

        <?php
        // Charge tout les résultats de la liste des spectacles du fetival dans un tableau
        $spectacleIDs = array();
        while ($row = $listeSpectacleDeFestival->fetch()) {
            $spectacleIDs[] = $row['idSpectacle'];
        }
            while ($spectacle = $listeSpectacles->fetch()) {
                ?>
                <div class="col-12">
                    <div class="centre">
                        <div class='cadreFestival'>
                            <?php
                                $idSpectacle = $spectacle['idSpectacle'];
                                echo $spectacle['titre']." ".$spectacle['duree'];
                            ?>

                            <input type="checkbox" name="Spectacles[]" id="<?php echo $spectacle['idSpectacle']; ?>" onchange="majListe(<?php echo $spectacle['idSpectacle'].','.$idFestival.','.$pageActuelle;?>,this.checked)" <?php

                            // Vérifier si le festival est deja dans la liste des festivals
                            if (in_array($spectacle['idSpectacle'], $spectacleIDs)) {
                                echo 'checked';

                            }

                            ?>>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="pagination">
            <?php for($page = 1; $page <= $nbPages; $page++) { ?>
                <a href="/festiplan?controller=Festival&action=modifierListeSpectacleFestival&page=<?php echo $page;?>&idFestival=<?php echo $idFestival;?>"><?php echo $page;?>   </a>
            <?php } ?>
        </div>        
            
        </div>
        <div class="footer">
            <a href="/festiplan?controller=Festival&action=afficherFestival&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn btn-gris">Retour</button></a>
        </div>
    </form>
    <script src="js/script.js"></script>
</body>
</html>