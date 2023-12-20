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
    <title>Ajouter un intervenant</title>
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
                <h2 class="texteCentre blanc bas">Ajouter un intervenant</h2>
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

        <label name="nom">Nom de l'intervenant :</label>
        <input type="text" id="nom" name="nom" required/>
        <br>
        <label name="nom">Prénom de l'intervenant :</label>
        <input type="text" id="prenom" name="prenom" required/>
        <br>
        <label name="mail" id="mail" name="mail">Adresse mail :</label>
        <input type="email" id="email" pattern=".+@example\.com" size="30" required/>
        <br>
        <label for="metierIntervenant">Métier intervenant :</label><br>    
            <select id="categorie" name="categorie" required>
                <?php
                while ($row = $searchStmt->fetch()) {?>
                    <option value="<?php echo $row['idCategorie'];?>"><?php echo $row['metier'];?></option>
                <?php
                }
                ?>
            </select>
        <div class="footer">
            <button type="submit" class="btn btn-bleu">Confirmer</button>   
            <a href="/festiplan?controller=Spectacle&action=afficherSpectacle&idSpectacle=<?php echo $idSpectacle;?>"><button type="button" class="btn btn-gris">Annuler</button></a>  
        </div>
    </form>
</body>
</html>