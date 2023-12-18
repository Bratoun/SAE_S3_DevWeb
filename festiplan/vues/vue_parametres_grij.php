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
    <body>
        <div class="container">
            <div class="row">
                <div class="col-2">
                    </img src="images/logo_noir.png">
                </div>
                <div class="col-10">
                    <h2>Paramétrage de la planification</h2>
                </div>
                <div class="col-2">
                    <button class="btn font-awesome-user"><span class="fas fa-solid fa-user"></span></button>
                </div>
            </div>
        </div>
    </body>
</html>