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
    <title>Créer un spectacle</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>
<header>
    <div class="header">Créer un spectacle<i class="fa-solid fa-user"></i></div>
</header>
<body id="body-blanc">
    <form action="index.php" method="post">
        <input type="hidden" name="controller" value="CreerSpectacleControleur">
        <input type="hidden" name="action" value="connexion">
        <div>
            Nom du spectacle:<br>
            <input type="text" name="titre" placeholder="(35 caractères maximum)" required/>
        </div>
        <div>
            Description :<br>   
            <textarea name="description" placeholder="(1000 caractères maximum)" required></textarea>
        </div>
        <div>
            Durée du spectacle :<br> <br>  
            <input name="duree" type="number"/>
        </div>
        <div>
        liste categorie :<br>    
            <select name="categorie" required>
                <?php
                while ($row = $searchStmt->fetch()) {?>
                    <option value=""><?php echo $row['nomCategorie'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div>
        Taille de surface requise : <br>
            <select name="taille" required>
                <?php
                while ($row = $search_stmt->fetch()) {?>
                    <option value=""><?php echo $row['nom'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn-bleu">Terminer</button>
    </form>
    <a href="/festiplan?controller=Accueil"><button class="btn-gris">Annuler</button></a>
</body>
</html>