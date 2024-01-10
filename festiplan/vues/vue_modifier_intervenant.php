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
    <title>Modifier un intervenant</title>
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
                <h2 class="texteCentre blanc bas">Modifier un intervenant</h2>
            </div>
            <div class="col-2 text-right"> <!-- Ajoutez la classe text-right pour aligner à droite -->
                <!-- Icône utilisateur avec menu déroulant -->
                <div class="dropdown">
                    <span class="fas fa-solid fa-user dropdown-btn iconeNoir icone-user"></span>
                    <div class="dropdown-content">
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageProfil">Profil</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageModifierProfil">Modifier Profil</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=pageDesinscription">Désinscription</a>
                        <a href="/festiplan?controller=UtilisateurCompte&action=deconnexion">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<body class="body-blanc">
    <form action="index.php" method="post">
          
        <input type="hidden" name="controller" value="Spectacle">
        <input type="hidden" name="action" value="nouveauIntervenant">
        <input type="hidden" name="idSpectacle" value="<?php echo $idSpectacle?>">
        <div class="container">
            <div class="row">
                <div class="col-12">
        <label name="nom">Nom de l'intervenant :</label>
        <input type="text" name="nom" required/>
        <br>
        </div>
        <div class="col-12">
        <label name="nom">Prénom de l'intervenant :</label>
        <input type="text" name="prenom" required/>
        <br>
        </div>
        <div class="col-12">
        <label name="LabelEmail">Adresse mail :</label>
        <input type="email" name="email"  size="50" required/>
        <br>
        </div>
        <div class="col-12">
        Métier intervenant :<br>    
        <select name="metierIntervenant" required>
            <option disabled value="0">Choisissez le métier de l'intervenant</option>
            <?php
            while ($row = $searchStmt->fetch()) {?>
                <option value="<?php echo $row['idMetierIntervenant'];?>"><?php echo $row['metier'];?></option>
            <?php
            }
            ?>
        </select>
        <?php
            while ($row = $searchStmt->fetch()) {?>
                <?php echo $row['idMetierIntervenant'];?>
            <?php
            }
            ?>
        <br>
        </div>
        <div class="col-12">
        Intervenant sur ou hors scène :<br>
        <select name="categorieIntervenant" required>
            <option value="0">Sur Scène</option>
            <option value="1">Hors Scène</option>
        </select>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-bleu">Confirmer</button>   
            <a href="/festiplan?controller=Spectacle&action=afficherSpectacle&idSpectacle=<?php echo $idSpectacle;?>"><button type="button" class="btn btn-gris">Annuler</button></a>  
        </div>
    </form>
</body>
</html>