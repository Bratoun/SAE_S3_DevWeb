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
            <input type="text" placeholder="(35 caractères maximum)" required/>
        </div>
        <div>
            Description :<br>   
            <textarea placeholder="(1000 caractères maximum)" required></textarea>
        </div>
        <div>
            Durée du spectacle :<br> <br>  
            <input type="number"/>
        </div>
        <div>
        liste categorie :<br>    
            <select required>
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
            <select required>
                <?php
                while ($row = $search_stmt->fetch()) {?>
                    <option value=""><?php echo $row['nom'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
<<<<<<< Updated upstream
        <button type="submit" class="btn-bleu">Terminer</button>
=======
        <div class="footer">
            <button type="submit" class="btn btn-bleu">Terminer</button>
            <a href="/festiplan?controller=Home"><button type="button" class="btn btn-gris">Annuler</button></a>
        </div>
>>>>>>> Stashed changes
    </form>
    <a href="/festiplan?controller=Accueil"><button class="btn-gris">Annuler</button></a>
</body>
</html>