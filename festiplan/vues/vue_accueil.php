<?php
// Vérifier si l'utilisateur est connecté
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
    <div class="header"><button class="btn btn-primary"><span class="fas fa-solid fa-user"><button></span></div>
</header>
<body id="body-blanc">
    <h1> Mes festivals/spectacles  <?php
                // while ($row = $mesFestivals -> fetch()) {
                //      echo $row['nom'];
                // }
                ?></h1>
    <a href="/festiplan?controller=CreerSpectacle"><button type="submit" class="btn-creer-spectacle">Créer un spectacle</button></a>
    <a href="/festiplan?controller=CreerFestival"><button type="submit" class="btn-bleu">Créer un festival</button></a>
    <button type="submit" class="btn-bleu">Deconnexion</button>
</body>
</html>