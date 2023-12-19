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
            <form action="/festiplan/index.php" method="post">
                <input name="controller" type="hidden" value="UtilisateurCompte">
                <input name="action" type="hidden" value="creerCompteUtilisateur">
                <input name="noRefresh" type="hidden" value="true">
                <input name="premierePage" type="hidden" value="true">
                <img src="static/images/logo_blanc.png" alt="Festiplan Logo">
                <br><br>
                <h2 class="grand">Inscription</h2>
                <br><br>
                <!-- fonctionne pas ! -->
                <div class="form-group texteGauche">
                    <?php
                    if (!$nomOk) {
                        echo '<p id="invalide">--> le nom ne doit pas depasser les 35 caracteres !</p>';
                    }
                    ?>
                    <input name="nom" type="text" class="form-control" placeholder="NOM" value="<?php if($nomOk){echo $ancienNom;}?>" required>
                </div>
                <div class="form-group texteGauche">
                    <?php
                    if (!$prenomOk) {
                        echo '<p id="invalide">--> le login ne doit pas depasser les 35 caracteres !</p>';
                    }
                    ?>
                    <input name="prenom" type="text" class="form-control" placeholder="PRENOM" value="<?php if($prenomOk){echo $ancienPrenom;}?>" required>
                </div>
                <div class="form-group texteGauche">
                    <?php
                    if (!$emailOk) {
                        echo '<p id="invalide">--> le login ne doit pas depasser les 35 caracteres !</p>';
                    }
                    ?>
                    <div class="input-group">
                        <input name="email" type="email" class="form-control" placeholder="ADRESSE MAIL" value="<?php if($emailOk){echo $ancienEmail;}?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-envelope"></span></span>
                        </div>
                    </div>                       
                </div>
                <br>
                <div class="texteCentre">
                    <button type="submit" class="btn btn-primary boutonFleche"><span class="fas fa-arrow-right"></span></button>
                </div>
                <div class="form-group texteGauche">
                    <?php
                    if (!$loginOk) {
                        echo '<p id="invalide">--> le login ne doit pas depasser les 35 caracteres !</p>';
                    }
                    ?>
                    <input name="login" type="text" class="form-control" placeholder="LOGIN" value="<?php if($loginOk){echo $ancienLogin;}?>" required>
                </div>
                <div class="form-group texteGauche">
                    <?php
                    if (!$mdpOk) {
                        echo '<p id="invalide">--> le mot de passe ne doit pas depasser les 30 caracteres !</p>';
                    }
                    ?>
                    <input name="mdp" type="password" class="form-control" placeholder="MOT DE PASSE" required>
                </div>
                <div class="form-group texteGauche">
                    <?php
                    if (!$confirmMdpOk) {
                        echo '<p id="invalide">--> la confirmation du mot de passe doit correspondre au mot de passe prescedement écrit !</p>';
                    }
                    ?>
                    <input name="confirmMdp" type="password" class="form-control" placeholder="CONFIRMER LE MOT DE PASSE" required>
                </div>
                <!-- fin de fonctionne pas -->
                <br>
                <div class="texteCentre">
                    <button type="submit" class="btn btn-secondary">Terminer</button>
                </div>
            </form>
            <div class="texteCentre">
                <a href="/festiplan?controller=UtilisateurCompte&action=creerCompteUtilisateur"><button type="button" class="btn btn-primary">Retour</button></a>
            </div>
            <br><br>
            <p class="texteCentre petit">Vous avez un compte ?  <a class="petit" href="/festiplan?controller=Home">CONNECTEZ VOUS</a></p>
        </div>
    </div>
</body>
</html>