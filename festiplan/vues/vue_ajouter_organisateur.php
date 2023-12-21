<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['utilisateur_connecte']) || $_SESSION['utilisateur_connecte'] == false) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter des Organisateurs :</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<!--En tête-->
<header>
    <div class="container-fluid header">
        <div class="row">
            <div class="col-2">
                <a href="index.php">
                    <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
            <div class="col-8">
                <h2 class="texteCentre blanc bas"> Ajouter des organisateurs : </h2>
            </div>
            <div class="col-2">
                <button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button>
            </div>
        </div>
    </div>
</header>
<body class="body-blanc">
    <form action="index.php" method="post">

        <input type="hidden" name="controller" value="Festival">
        <input type="hidden" name="action" value="majOrganisateur">
        <input type="hidden" name="idFestival" value="<?php echo $idFestival?>">
        
        <?php
            echo $nomFestival;
        ?>
        <br>
        Liste des Organisateurs : <br>
        <?php
        // Charger tous les résultats de la liste des organisateurs dans un tableau
        $organisateurIDs = array();
        while ($row2 = $listeOrganisateur->fetch()) {
            $organisateurIDs[] = $row2['idUtilisateur'];
        }

        // Revenir au début de la liste des organisateurs
        $listeOrganisateur->execute();

        while ($row = $listeUtilisateur->fetch()) {
            ?>
            <input type="checkbox" name="Utilisateur[]" value="<?php echo $row['idUtilisateur']; ?>" <?php
            // Vérifier si l'utilisateur est dans la liste des organisateurs
            if (in_array($row['idUtilisateur'], $organisateurIDs)) {
                echo 'checked';
                    
            }
            // Rend le responsable impossible a uncheck
            if ($row['idUtilisateur'] == $idResponsable) {
                echo ' disabled';
            }
            ?>>
            <?php echo $row['nom']; ?>
            <br>
            <?php
        }
        ?>
        <div class="footer">
            <button type="submit" class="btn btn-bleu">Confirmer</button>   
            <a href="/festiplan?controller=Festival&action=afficherFestival&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn btn-gris">Annuler</button></a>  
        </div>
    </form>
</body>
</html>