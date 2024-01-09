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
                <h2 class="texteCentre blanc bas">Intervenants</h2>
            </div>
            <div class="col-2">
                <a href="/festiplan?controller=UtilisateurCompte&action=pageProfil"><button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button></a>
            </div>
        </div>
    </div>
</header>
<body class="body-blanc">
    <div class="container-fluid">
    <table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Métier</th>
        <th>Status</th>
        <th></th>
    </tr>
</table>
    </div>

    <div class="footer col-12">
            <button type="submit" class="btn btnModif fondBleu">Terminer</button>
            <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondGris">Retour</button></a>
            <a href="/festiplan?controller=Spectacle&action=ajouterIntervenant&idSpectacle=<?php echo $idSpectacle;?>"><button type="button" class="btn btnModif fondGris">Ajouter un intervenant</button></a>
        </div>
</body>
</html> 