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
                <h2 class="texteCentre blanc bas"> Créer un festival : </h2>
            </div>
            <div class="col-2 text-right"> <!-- Ajoutez la classe text-right pour aligner à droite -->
                <!-- Icône utilisateur avec menu déroulant -->
                <div class="dropdown">
                    <span class="fas fa-solid fa-user dropdown-btn iconeBlanc icone-user"></span>
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

        <input type="hidden" name="controller" value="Festival">
        <input type="hidden" name="action" value="nouveauOuModificationFestival">
        <input type="hidden" name="modifier" value="false">

        <div class="form-group texteGauche">
            <label id="<?php if(!$nomOk){echo 'invalide';}?>">Nom :</label>
            <input name="nom" type="text"  placeholder="(max 35 caractére)" value="<?php if($nomOk){echo $ancienNom;}?>" required>
        </div>
        <div class="form-group texteGauche">
        <label id="<?php if(!$descOk){echo 'invalide';}?>">Description :</label>
            <input name="description" type="textarea"  placeholder="(max 1000 caractére)" value="<?php if($descOk){echo $ancienneDesc;}?>" required>
        </div>
        <div class="form-group texteGauche">
        <label id="<?php if(!$dateOk){echo 'invalide';}?>">Date de début :</label>
            <input name="dateDebut" type="date" value="<?php if($dateOk){echo $ancienneDateDebut;}?>" required>
        </div>
        <div class="form-group texteGauche">
            <label id="<?php if(!$dateOk){echo 'invalide';}?>">Date de fin :</label>
            <input name="dateFin" type="date" value="<?php if($dateOk){echo $ancienneDateFin;}?>" required>
        </div>
        <div class="form-group texteGauche">
            Liste categorie :
            <select name="categorie" required>
                <?php
                while ($row = $searchStmt -> fetch()) {?>
                    <option value="<?php echo $row['idCategorie'];?>"  <?php if ($row['idCategorie'] == $ancienneCategorie) { echo 'selected';}?>  ><?php echo $row['nom'];?></option>
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