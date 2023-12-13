<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Page de Connexion</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="cadreConnexion">
            <form action="index.php" method="post">
            <h2 class="grand">Connexion</h2>
                <br><br>
                <div class="form-group texteGauche">
                    <input type="text" class="form-control" placeholder="NOM D'UTILISATEUR" required>
                </div>
                <div class="form-group texteGauche">
                    <input type="password" class="form-control" placeholder="MOT DE PASSE" required>
                </div>
                <br>
                <div class="form-check texteGauche">
                    <input type="checkbox" class="form-check-input" id="resterConnecte">
                    <label class="form-check-label" for="resterConnecte">Rester connecté</label>
                </div>
                <br><br>
                <div class="texteCentre">
                    <button type="submit" class="btn btn-primary"><span class="fas fa-arrow-right"></span></button>
                </div>
                <br><br>
            </form>
<<<<<<< HEAD
<<<<<<< HEAD
            <form action="index.php" method="post">
=======
            <form action="vueInscription.php" method="post">
>>>>>>> 0b1de11f5f59c08e654497175f62afea2e3db5ba
=======
            <form action="vueInscription.php" method="post">
>>>>>>> 3c3b2ec96bf95963ef3e087fb30cd7754791d0ae
                <p class="texteCentre petit">Vous n'avez pas de compte ? <button class="btn petit">CREER UN COMPTE</button></p>
            </form>
        </div>
    </div>
</body>
</html>
