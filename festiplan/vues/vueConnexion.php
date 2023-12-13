<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Page de Connexion</title>
    <link href="bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css"/>
    <link href="fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="cadreConnexion">
            <form>
            <h2 class="grand">Connexion</h2>
            <br><br>
                <div class="form-group texteGauche">
                    <input type="text" class="form-control" placeholder="NOM D'UTILISATEUR">
                </div>
                <div class="form-group texteGauche">
                    <input type="password" class="form-control" placeholder="MOT DE PASSE">
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
            <p class="texteCentre petit">Vous n'avez pas de compte ? <button href="pages/inscription.php" class="btn petit">CREER UN COMPTE</button></p>
            </form>
        </div>
    </div>
</body>
</html>