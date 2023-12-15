<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un festival</title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>

<header>
    <div class="header"><a href="/festiplan?controller=Accueil"><i class="fa-solid fa-user"></i></a> Créer un Festival</div>
</header>

<body id="body-blanc">
    <form action="/festiplan?controller=Accueil" method="post">
        <div class="form-group texteGauche">
            Nom :<input type="text"  placeholder="(max 35 caractére)" required>
        </div>
        <div class="form-group texteGauche">
            Description :<input type="textarea"  placeholder="(max 1000 caractére)" required>
        </div>
        <div class="form-group texteGauche">
            Date de début :<input type="date"  required>
        </div>
        <div class="form-group texteGauche">
            Date de fin: <input type="date"  required>
        </div>
        <div class="form-group texteGauche">
            Liste categorie :
            <select required>
                <?php
                while ($row = $categorie) {?>
                    <option value=""><?php echo $row['nomCategorie'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn-bleu">Terminer</button>
    </form>
    <a href="/festiplan?controller=Accueil"><button type="submit" class="btn-gris">Annuler</button></a>
    
</body>
</html>