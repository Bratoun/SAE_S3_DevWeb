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
    <title>Accueil</title>
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
                <h2 class="texteCentre blanc bas"> Créer un spectacle : </h2>
            </div>
            <div class="col-2">
                <button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button>
            </div>
        </div>
    </div>
</header>
<body class="body-blanc">
    <form action="index.php" method="post">

        <input type="hidden" name="controller" value="Spectacle">
        <input type="hidden" name="action" value="nouveauSpectacle">
        
        <div>
            <label id="<?php if(!$titreOk){echo 'invalide';}?>">Titre :</label>
            <input type="text" id="titre" name="titre" placeholder="(35 caractères maximum)" value="<?php if($titreOk){echo $ancienTitre;}?>" required>
        </div>
        <div>
            <label id="<?php if(!$descOk){echo 'invalide';}?>">Description :</label>   
            <input name="description" type="textarea"  placeholder="(max 1000 caractére)" value="<?php if($descOk){echo $ancienneDesc;}?>" required>
        </div>
        <div>
            <label id="<?php if(!$dureeOk){echo 'invalide';}?>">Duree du spectacle (en minutes) :</label>
            <input id="duree" name="duree" type="number" value="<?php if($dureeOk){echo $ancienneDuree;}?>" required>
        </div>
        <div>
            <label for="categorie">Liste catégorie :</label><br>    
            <select id="categorie" name="categorie" required>
                <?php
                while ($row = $searchStmt->fetch()) {?>
                    <option value="<?php echo $row['idCategorie'];?>"  <?php if ($row['idCategorie'] == $ancienneCategorie) { echo 'selected';}?>  ><?php echo $row['nomCategorie'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="taille">Taille de surface requise :</label><br>
            <select id="taille" name="taille" required>
                <?php
                while ($row = $search_stmt->fetch()) {?>
                    <option value="<?php echo $row['idTaille'];?>"  <?php if ($row['idTaille'] == $ancienneTaille) { echo 'selected';}?>  ><?php echo $row['nom'];?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="container-fluid footer">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btnModif fondBleu">Terminer</button>
                </div>
                <div class="col-6">
                    <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondGris">Annuler</button></a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>