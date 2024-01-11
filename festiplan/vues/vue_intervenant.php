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
    <title>Intervenant</title>
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
                <h2 class="texteCentre blanc bas">Intervenants</h2>
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
    <div class="container-fluid">
    <?php

        if ($search_stmt->rowCount() > 0) {
            
    ?>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Métier</th>
                    <th>Statuts</th>
                    <th>Modifier</th>
                    <th>supprimer</th>
                </tr>
                <?php while ($row = $search_stmt->fetch()) { ?>
                <tr>
                    <td><?php echo $row['nom'] ?></td>
                    <td><?php echo $row['prenom'] ?></td>
                    <td><?php echo $row['metier'] ?></td>
                    <td><?php if ($row['surScene'] == 0) { echo "Sur scène"; } else { echo "Hors scène";} ?></td>
                    <td><a href="/festiplan?controller=Spectacle&action=modifierIntervenant&idIntervenant=<?php echo $row['idIntervenant'];?>&idSpectacle=<?php echo $row['idSpectacle'];?>">Modifier</a></td>
                    <td><a href=""data-id-intervenant="<?php echo $row['idIntervenant'];?>" data-id-spectacle="<?php echo $row['idSpectacle'];?>" class="suppIntervenant">Supprimer</a></td>
                </tr>
                <?php } ?>
            </table>
            </div>
    <?php
        } else{
            
            echo "<h1>Vous n'avez aucun intervenant pour ce spectacle</h1>";
    ?>
    
    <?php 
        }
    ?>
    <div class="footer col-12">
        <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondBleu">Terminer</button></a>
        <a href="/festiplan?controller=Home"><button type="button" class="btn btnModif fondGris">Retour</button></a>
        <a href="/festiplan?controller=Spectacle&action=ajouterIntervenant&idSpectacle=<?php echo $idSpectacle;?>"><button type="button" class="btn btnModif fondGris">Ajouter un intervenant</button></a>
    </div>
    <script src="js/script.js"></script>
</body>
</html> 