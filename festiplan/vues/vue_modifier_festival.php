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
    <title>Modifier un festival </title>
    <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/index.css"/>
    <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
</head>

<!-- En tête -->
<header>
    <div class="container-fluid header">
        <div class="row">
            <div class="col-2">
                <a href="index.php">
                    <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
            <div class="col-8">
                <h2 class="texteCentre blanc bas"> Modifier un festival  </h2>
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
        <input type="hidden" name="modifier" value="true">
        <input type="hidden" name="idFestival" value="<?php echo $idFestival?>">

        <div class="row">
            <div class="col-12">
                <div class="form-group texteGauche">
                    <label id="<?php if(!$nomOk){echo 'invalide';}?>">Nom :</label>
                    <br>
                    <input name="nom" type="text"  placeholder="(max 35 caractère)" value="<?php if($nomOk){echo $ancienNom;}?>" required class="input-style">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group texteGauche">
                    <label id="<?php if(!$descOk){echo 'invalide';}?>">Description :</label>
                    <br>
                    <textarea name="description" placeholder="(max 1000 caractère)" required class="textarea-style"><?php if($descOk){echo $ancienneDesc;}?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group texteGauche">
                    <label id="<?php if(!$dateOk){echo 'invalide';}?>">Date de début :</label>
                    <br>
                    <input name="dateDebut" type="date" value="<?php if($dateOk){echo $ancienneDateDebut;}?>" required class="input-style">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group texteGauche">
                    <label id="<?php if(!$dateOk){echo 'invalide';}?>">Date de fin :</label>
                    <br>
                    <input name="dateFin" type="date" value="<?php if($dateOk){echo $ancienneDateFin;}?>" required class="input-style">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group texteGauche">
                    Liste categorie :
                    <br>
                    <select name="categorie" required class="input-style">
                        <?php
                        while ($row = $searchStmt -> fetch()) {?>
                            <option value="<?php echo $row['idCategorie'];?>"  <?php if ($row['idCategorie'] == $ancienneCategorie) { echo 'selected';}?>  ><?php echo $row['nom'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group texteGauche">
                    Organisateur :
                    <?php
                        while ($row = $listeOrganisateur-> fetch()) {
                            echo $row['nom']."<br>";
                        
                        }
                    if($estResponsable) {?>
                        <a href="/festiplan?controller=Festival&action=gestionOrganisateur&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn fondGris">ajouter des Organisateur</button></a>  
                    <?php } ?>
                </div>
                </div>
                </div>
        <div class="footer">
            <button type="submit" class="btn btnModif fondVert">Confirmer</button>   
            <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondGris">Annuler</button></a>  
            <?php if($estResponsable) {?>
                <button type="button" id="suppressionFestival" class="btn btnModif fondRouge" data-id-festival="<?php echo $idFestival; ?>">Supprimer</button>
            <?php } ?>
            <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondBleu">Consulter la planification</button></a>
            <a href="/festiplan?controller=Festival&action=modifierListeSpectacleFestival&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn btnModif fondBleu">Modifier la liste des spectacles</button></a>
        </div>
    </form>
    <script src="js/script.js"></script>
</body>
</html>
