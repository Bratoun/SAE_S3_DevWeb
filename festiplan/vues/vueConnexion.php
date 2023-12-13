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
            <form action="/festiplan?controller=Accueil" method="post">
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
            <p class="petit">Vous n'avez pas de compte<a href="/mezabi?controller=Articles">CREER UN COMPTE</a></p>
        </div>
    </div>
</body>
</html>
