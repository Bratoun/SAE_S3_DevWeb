<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
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
                <h2 class="grand">Modifier vos informations</h2>
                <br>
                
                <input type="hidden" name="controller" value="UtilisateurCompte">
                <input type="hidden" name="action" value="modifierCompteUtilisateur">

                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="login" type="text" class="form-control <?php echo (!$loginOk) ? 'placeholder-invalid' : ''; ?>" 
                               <?php if (!$loginOk) echo 'placeholder="Login invalide !"'; ?> 
                               value="<?php echo ($loginOk) ? $ancienLogin : ''; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-user"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group texteGauche row">
                    <div class="col-md-6 col-12">
                        <div class="input-group">
                            <input name="prenom" type="text" class="form-control <?php echo (!$prenomOk) ? 'placeholder-invalid' : ''; ?>" 
                                   <?php if (!$prenomOk) echo 'placeholder="Prenom invalide !"'; ?> 
                                   value="<?php echo ($prenomOk) ? $ancienPrenom : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="input-group">
                            <input name="nom" type="text" class="form-control <?php echo (!$nomOk) ? 'placeholder-invalid' : ''; ?>" 
                                   <?php if (!$nomOk) echo 'placeholder="Nom invalide !"'; ?> 
                                   value="<?php echo ($nomOk) ? $ancienNom : ''; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="mdp" type="password" class="form-control <?php echo (!$mdpOk) ? 'placeholder-invalid' : ''; ?>" 
                               placeholder="<?php echo (!$mdpOk) ? 'Mot de passe non conforme !' : 'MOT DE PASSE'; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-lock"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="confirmMdp" type="password" class="form-control <?php echo (!$confirmMdpOk) ? 'placeholder-invalid' : ''; ?>" 
                               placeholder="<?php echo (!$confirmMdpOk) ? 'Mot de passe différent !' : 'CONFIRMER MOT DE PASSE'; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-lock"></span></span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="texteCentre">
                    <button type="submit" class="btn btn-primary boutonTerminer">Modifier</button>
                    <a href="index.php"><button type="button" class="btn fondGris boutonTerminer">Annuler</button></a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
