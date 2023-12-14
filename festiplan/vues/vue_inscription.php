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
                // Vérifier si le formulaire a été soumis
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    // Changer les placeholders après la soumission du formulaire
                    $placeholderNom = "LOGIN";
                    $placeholderPrenom = "MOT DE PASSE";
                    $placeholderEmail = "CONFIRMER LE MOT DE PASSE";

                    // Afficher les boutons terminer et annuler
                    $showButtons = true;
                } else {
                    // Les valeurs par défaut si le formulaire n'a pas été soumis
                    $placeholderNom = "NOM";
                    $placeholderPrenom = "PRENOM";
                    $placeholderEmail = "ADRESSE MAIL";

                    // Ne pas afficher les boutons terminer et annuler
                    $showButtons = false;
                }
            ?>
            <form action="/festiplan?controller=Inscription" method="post">
                <img src="static/images/logo_blanc.png" alt="Festiplan Logo">
                <br><br>
                <h2 class="grand">Inscription</h2>
                <br><br>
                <div class="form-group texteGauche">
                    <input name="nom" type="text" class="form-control" placeholder="<?php echo $placeholderNom; ?>" required>
                </div>
                <div class="form-group texteGauche">
                    <input name="prenom" type="text" class="form-control" placeholder="<?php echo $placeholderPrenom; ?>" required>
                </div>
                <div class="form-group texteGauche">
                    <div class="input-group">
                        <input name="email" type="text" class="form-control" placeholder="<?php echo $placeholderEmail; ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="fas fa-solid fa-envelope"></span></span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="texteCentre">
                    <?php
                        if ($showButtons) {
                            // Afficher les boutons terminer et annuler
                            echo '<button type="button" class="btn btn-success">Terminer</button>';
                            echo '<button type="button" class="btn btn-danger">Annuler</button>';
                        } else {
                            // Afficher le bouton submit
                            echo '<button type="submit" class="btn btn-primary"><span class="fas fa-arrow-right"></span></button>';
                        }
                    ?>
                </div>
                <br><br>
            </form>
            <p class="texteCentre petit">Vous avez un compte ? <a class="petit" href="/festiplan?controller=Home">CONNECTEZ VOUS</a></p>
        </div>
    </div>
</body>
</html>
