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
            <?php
                if ($premierePage) {
                    ?>
                    <form action="/festiplan/index.php" method="post">
                        <input name="controller" type="hidden" value="UtilisateurCompte">
                        <input name="action" type="hidden" value="creerCompteUtilisateur">
                        <input name="noRefresh" type="hidden" value="true">
                        <input name="premierePage" type="hidden" value="true">
                        <img src="static/images/logo_blanc.png" alt="Festiplan Logo">
                        <br><br>
                        <h2 class="grand">Inscription</h2>
                        <br><br>
                        <div class="form-group texteGauche">
                            <input name="nom" type="text" class="form-control" placeholder="NOM" required>
                        </div>
                        <div class="form-group texteGauche">
                            <input name="prenom" type="text" class="form-control" placeholder="PRENOM" required>
                        </div>
                        <div class="form-group texteGauche">
                            <div class="input-group">
                                <input name="email" type="email" class="form-control" placeholder="ADRESSE MAIL" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><span class="fas fa-solid fa-envelope"></span></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="texteCentre">
                            <button type="submit" class="btn btn-primary boutonFleche"><span class="fas fa-arrow-right"></span></button>
                        </div>
                    </form>
                    <?php
                } else {

                    ?>
                    <form action="/festiplan/index.php" method="post">
                        <input name="editer" type="hidden" value="true">
                        <input name="controller" type="hidden" value="UtilisateurCompte">
                        <input name="action" type="hidden" value="creerCompteUtilisateur">
                        <input name="noRefresh" type="hidden" value="true">
                        <input name="nom" type="hidden" value="<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>">
                        <input name="prenom" type="hidden" value="<?php if (isset($_POST['prenom'])) echo $_POST['prenom']; ?>">
                        <input name="email" type="hidden" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                        <img src="static/images/logo_blanc.png" alt="Festiplan Logo">
                        <br><br>
                        <h2 class="grand">Inscription</h2>
                        <br><br>
                        <div class="form-group texteGauche">
                            <input name="login" type="text" class="form-control" placeholder="LOGIN" required>
                        </div>
                        <div class="form-group texteGauche">
                            <input name="mdp" type="password" class="form-control" placeholder="MOT DE PASSE" required>
                        </div>
                        <div class="form-group texteGauche">
                            <div class="input-group">
                                <input name="confirmMdp" type="password" class="form-control" placeholder="CONFIRMER LE MOT DE PASSE" required>
                            </div>
                        </div>
                        <br>
                        <div class="texteCentre">
                                <button type="submit" class="btn btn-secondary">Terminer</button>
                        </div>
                    </form>
                    <div class="texteCentre">
                        <a href="/festiplan?controller=UtilisateurCompte&action=creerCompteUtilisateur"><button type="button" class="btn btn-primary">Retour</button></a>
                    </div>
                <?php
                }
            ?>
            <br><br>
            <p class="texteCentre petit">Vous avez un compte ?  <a class="petit" href="/festiplan?controller=Home">CONNECTEZ VOUS</a></p>
        </div>
    </div>
</body>
</html>