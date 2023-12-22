<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Desinscription</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<header>
    <div class="container-fluid header-blanc">
        <div class="row">
            <div class="col-2">
                <a href="index.php">
                    <img src="static/images/logo_blanc.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
        </div>
    </div>
</header>
<body>
    <div class="container containerCentre">
        <div class="cadreUtilisateur connexion plusBas">
            <form action="index.php" method="post">
                <h2 class="grand">Desinscription</h2>
                <br><br>

                <input type="hidden" name="controller" value="UtilisateurCompte">
                <input type="hidden" name="action" value="supprimerProfil">

                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="login" type="text" class="form-control <?php echo (!$loginOk) ? 'placeholder-invalid' : ''; ?>" 
                            placeholder="<?php echo (!$loginOk) ? 'Login invalide !' : 'LOGIN'; ?>"  required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-user"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="mdp" type="password" class="form-control <?php echo (!$mdpOk) ? 'placeholder-invalid' : ''; ?>" 
                            placeholder="<?php echo (!$mdpOk) ? 'Mot de passe invalide !' : 'MOT DE PASSE'; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-lock"></span></span>
                        </div>
                    </div>
                <br><br>
                <div class="texteCentre">
                    <a href="/festiplan?controller=UtilisateurCompte&action=pageProfil"><button type="button" class="btn fondGris boutonTerminer">Retour</button></a>
                </div>
                <div class="texteCentre">
                    <button type="submit" class="btn fondRouge boutonTerminer">Se desinscrire</button></a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
