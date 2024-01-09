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
                    <h2 class="texteCentre blanc bas"> Parametrage de la plannification : </h2>
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
            <?php if ($message != null) echo "<h1>".$message."</h1>";?>
            <div class="row">
                <div class="col-12" id="parametres-grij">
                    <form method="post" action="index.php">
                        <input type="hidden" name="controller" value="Grij"/>
                        <input type="hidden" name="action" value="enregistrerGrij"/> 
                        <div class="row">
                            <input type="hidden" name="idFestival" value="<?php echo $idFestival;?>"/> 
                            <div class="col-12">
                                <label for="heureDebut">Heure de début :</label>
                            </div>
                            <div class="col-12">
                                <input type="time" name="heureDebut" value="<?php echo $heureDebut;?>"/>
                            </div>
                            <div class="col-12">
                                <label for="heureFin">Heure de fin :</label>
                            </div>
                            <div class="col-12">
                                <input type="time" name="heureFin" value="<?php echo $heureFin;?>"/>
                            </div>
                            <div class="col-12">
                                <label for="ecartEntreSpectacles">Écart entre chaque spectacle :</label>
                            </div>
                            <div class="col-12">
                                <input type="time" name="ecartEntreSpectacles" value="<?php echo $ecartEntreSpectacles;?>">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Annule les modification du jour sélectionné -->
                            <div class="col-4">
                                <a href="/festiplan?controller=Home"><button type="button" class="btn btn-warning">Annuler</button></a>
                            </div>
                            <!-- Enregistre les paramètres du jour sélectionné -->
                            <div class="col-4">
                                <input type="submit" class="btn btn-success" value="Valider"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>