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
                <div class="col-2">
                    <button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button>
                </div>
            </div>
        </div>
    </header>
    <body class="body-blanc">
        <div class="container">
            <div class="row">
                <?php
                // Liste des jours du festival
                    while($listeJours as $jour)
                    {
                        ?>
                        <div class="cadre col-3">
                            <h1><?php echo $jour['dateJour'];?></h1>
                            <?php
                            // Liste des spetacles du jour du festival
                            echo $jour['titre'];
                            // foreach($jour['titre'])
                            ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </body>
</html>