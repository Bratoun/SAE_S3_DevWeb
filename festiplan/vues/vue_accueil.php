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
    <div class="container-fluid">
        <div class="row header">
            <div class="col-2">
                <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
            </div>
            <div class="col-8">
                <h1 class="texteCentre blanc"> Mes festivals/spectacles : </h1>
            </div>
            <div class="col-2">
                <button class="btn font-awesome-user"><span class="fas fa-solid fa-user"></span></button>
            </div>
        </div>
    </div>
</header>
<body id="body-blanc">
    <div class="footer">
            <a href="/festiplan?controller=CreerSpectacle"><button type="submit" class="btn btn-gris">Créer un spectacle</button></a>
            <a href="/festiplan?controller=CreerFestival"><button type="submit" class="btn btn-bleu">Créer un festival</button></a>
            <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion"><button type="submit" class="btn btn-danger">Deconnexion</button></a>
    </div>
</body>
</html>