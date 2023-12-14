<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="cadreConnexion">
            <form action="/festiplan?controller=Inscription" method="post">
            <h2 class="grand">Inscription</h2>
            <br><br>
                <div class="form-group texteGauche">
                    <input name="nom" type="text" class="form-control" placeholder="NOM" required>
                </div>
                <div class="form-group texteGauche">
                    <input name="prenom" type="text" class="form-control" placeholder="PRENOM" required>
                </div>
                <div class="form-group texteGauche">
                    <input name="email" type="text" class="form-control" placeholder="ADRESSE MAIL" required>
                </div>
                <br>
                <div class="texteCentre">
                    <button type="submit" class="btn btn-primary"><span class="fas fa-arrow-right"></span></button>
                </div>
                <br><br>
            </form>
            <p class="texteCentre petit">Vous avez un compte ? <a class="petit" href="/festiplan?controller=Home">CONNECTEZ VOUS</button></p>
        </div>
    </div>
</body>
</html>
