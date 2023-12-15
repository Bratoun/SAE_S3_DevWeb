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
                if (!$premierePage) {
                    // Changer les placeholders après la soumission du formulaire
                    $nomLogin = "login";
                    $prenomMdp = "mdp";
                    $emailConfMdp = "confMdp";
                    $placeholderNom = "LOGIN";
                    $placeholderPrenom = "MOT DE PASSE";
                    $placeholderEmail = "CONFIRMER LE MOT DE PASSE";
                } else {
                    // Les valeurs par défaut si le formulaire n'a pas été soumis
                    $nomLogin = "nom";
                    $prenomMdp = "prenom";
                    $emailConfMdp = "email";
                    $placeholderNom = "NOM";
                    $placeholderPrenom = "PRENOM";
                    $placeholderEmail = "ADRESSE MAIL";
                }
            ?>
            <form action="/festiplan/index.php" method="post">
                <input name="editer" type="hidden" value="<?php if ($premierePage) {echo 'false';}else{echo 'true';} ?>">
                <input name="premierePage" type="hidden" value="false">
                <input name="controller" type="hidden" value="UtilisateurCompte">
                <input name="action" type="hidden" value="creerCompteUtilisateur">
                <input name="noRefresh" type="hidden" value="true">
                <img src="static/images/logo_blanc.png" alt="Festiplan Logo">
                <br><br>
                <h2 class="grand">Inscription</h2>
                <br><br>
                <div class="form-group texteGauche">
                    <input name="<?php echo $nomLogin; ?>" type="text" class="form-control" placeholder="<?php echo $placeholderNom; ?>" required>
                </div>
                <div class="form-group texteGauche">
                    <input name="<?php echo $prenomMdp; ?>" type="text" class="form-control" placeholder="<?php echo $placeholderPrenom; ?>" required>
                </div>
                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="<?php echo $emailConfMdp; ?>" type="text" class="form-control" placeholder="<?php echo $placeholderEmail; ?>" required>
                        <div class="input-group-append">
                            <?php if($premierePage){echo '<span class="input-group-text"><span class="fas fa-solid fa-envelope"></span></span>';}?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="texteCentre">
                    <?php
                        if ($premierePage) {?>
                        
                            <button type="submit" class="btn btn-primary"><span class="fas fa-arrow-right"></span></button>
                        
                        <?php
                        } else {?>
                            <button type="submit" class="btn btn-secondary">Terminer</button>
                        <?php
                        }
                    ?>
                </div>
            </form>
            <?php
                if (!$premierePage) {?>
                <div class="texteCentre">
                    <a href="/festiplan?controller=UtilisateurCompte&action=creerCompteUtilisateur"><button type="button" class="btn btn-primary">Retour</button></a>
                </div>
                <?php
                }?>
            <br><br>
            <p class="texteCentre petit">Vous avez un compte ? <a class="petit" href="/festiplan?controller=Home">CONNECTEZ VOUS</a></p>
        </div>
    </div>
</body>
</html>