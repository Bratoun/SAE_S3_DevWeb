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
    <form action="/festiplan?controller=Accueil" method="post">
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
                <option value="petit">Petite</option>
                <option value="moyenne">Moyenne</option>
                <option value="grande">Grande</option>
            </select>
        </div>
        <button type="submit" class="btn-bleu">Terminer</button>
    </form>
    <a href="/festiplan?controller=Accueil"><button class="btn-gris">Annuler</button></a>
</body>
</html>