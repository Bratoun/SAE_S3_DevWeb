<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
    <style>
        @media (max-width: 767px) {
            .container {
                margin-top: 30px;
            }
        }
    </style>
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
            <div class="row">
                <h2 class="grand col-10">Informations sur le compte</h2>
                <a class="col-2" href="/festiplan?controller=UtilisateurCompte&action=pageModifierProfil">
                    <button class='btn icone-pencil'>
                        <span class="fas fa-solid fa-pencil"></span>
                    </button>
                </a>
            </div>
            <br>

            <div class="form-group texteCentre mx-auto"> <!-- Ajout des classes texteCentre et mx-auto -->
                <div class="input-group">
                    <p>Prénom : <?php echo $ancienPrenom; ?><p>
                </div>
            </div>
            <div class="form-group texteCentre mx-auto"> <!-- Ajout des classes texteCentre et mx-auto -->
                <div class="input-group">
                    <p>Nom : <?php echo $ancienNom; ?></p>
                </div>
            </div>
            <div class="form-group texteCentre mx-auto"> <!-- Ajout des classes texteCentre et mx-auto -->
                <div class="input-group">
                    <p>Login : <?php echo $ancienLogin; ?></p>
                </div>
            </div>
            <div class="form-group texteCentre mx-auto"> <!-- Ajout des classes texteCentre et mx-auto -->
                <div class="input-group">
                    <p>Email : <?php echo $ancienEmail; ?></p>
                </div>
            </div>
            <br>
            <div class="texteCentre">
                <a href="index.php"><button type="button" class="btn fondGris boutonTerminer">Retour</button></a>
            </div>
            <div class="texteCentre">
                <a href="/festiplan?controller=UtilisateurCompte&action=pageDesinscription"><button type="button" class="btn fondRouge boutonTerminer">Se désinscrire</button></a>
            </div>
            <div class="texteCentre">
                <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion"><button type="button" class="btn fondViolet boutonTerminer">Deconnexion</button></a>    
            </div>
        </div>
    </div>
</body>
</html>
