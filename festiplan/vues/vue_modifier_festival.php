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
                <h2 class="texteCentre blanc bas"> Modifier un festival : </h2>
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
        <input type="hidden" name="action" value="nouveauOuModificationFestival">
        <input type="hidden" name="modifier" value="true">
        <input type="hidden" name="idFestival" value="<?php echo $idFestival?>">

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
        <div class="form-group texteGauche">
            Organisateur :
            <?php
                while ($row = $listeOrganisateur-> fetch()) {
                    echo $row['nom'];
                
                }
            if($estResponsable) {?>
                <a href="/festiplan?controller=Festival&action=ajouterOrganisateur&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn btn-gris">ajouter des Organisateur</button></a>  
            <?php } ?>
        </div>
        <div class="footer">
            <button type="submit" class="btn btn-bleu">Confirmer</button>   
            <a href="/festiplan?controller=Home"><button type="button" class="btn btn-gris">Annuler</button></a>  
            <?php if($estResponsable) {?>
                <a href="/festiplan?controller=Festival&action=supprimerFestival&idFestival=<?php echo $idFestival;?>"> <button type="button" class="btn btn-rouge">Supprimer</button></a>
            <?php } ?>
            <a href="/festiplan?controller=Home"><button type="button" class="btn btn-bleu">Consulter la planification</button></a>
            <a href="/festiplan?controller=Home"><button type="button" class="btn btn-bleu">Modifier la liste des spectacles</button></a>
        </div>
    </form>
</body>
</html>