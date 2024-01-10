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
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <a href="index.php">
                    <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                </a>
            </div>
            <div class="col-8">
                <h2 class="texteCentre blanc bas"><?php if ($afficher) {echo 'Mes spectacles';} else { echo 'Mes festivals';}?></h2>
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
    <div class="container-fluid">
    <?php
        // Affichage de la liste des spectacles
        if ($afficher) {
            if ($mesSpectacles->rowCount() > 0) {
                ?>
                
                <?php
                while ($listeSpectacle = $mesSpectacles->fetch()) {
                    ?>
                    <div class="col-12">
                        <div class="centre">
                            <div class='cadreFestival'>
                                <?php
                                    $idSpectacle = $listeSpectacle['idSpectacle'];
                                    echo $listeSpectacle['titre'];
                                ?>
                                <a href="/festiplan?controller=Spectacle&action=afficherSpectacle&idSpectacle=<?php echo $idSpectacle;?>"><button type="submit" class="btn fondBleu">Modifier le Spectacle</button></a>
                                <button type="button" name="suppression" class="btn btnModif fondRouge" data-id-spectacle="<?php echo $idSpectacle; ?>">Supprimer le spectacle</button>
                                <a href="/festiplan?controller=Spectacle&action=afficherIntervenant&idSpectacle=<?php echo $idSpectacle;?>"><button type="submit" class="btn fondBleu">Les intervenants du spectacle</button></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="pagination">
                    <?php for($page = 1; $page <= $nbPages; $page++) { ?>
                        <a href="/festiplan?controller=Home&page=<?php echo $page;?>&afficher=<?php echo $afficher;?>"><?php echo $page;?>   </a>
                    <?php } ?>
                </div>
                <?php
            } else {
                echo '<div class="col-12">';
                    echo '<div class="centre">';
                        echo 'Pas de spectacle créer pour le moment';
                    echo '</div>';
                echo '</div>';
            }   
        } else {
            if ($mesFestivals->rowCount() > 0) {
                ?>
                
                <?php
                //affichage de la liste des festivals
                while ($festival = $mesFestivals->fetch()) {
                    $idFestival = $festival['idFestival'];
                ?>  
                    <div class="row">
                        <div class="col-12">
                            <a href='/festiplan?controller=Grij&idFestival=<?php echo $idFestival;?>'>
                                <div class="centre">  
                                    <div class='cadreFestival'>
                                        <?php
                                        echo $festival['titre']."<br>";
                                        echo $festival['nom'];
                                        ?>
                                        <a href="/festiplan?controller=Festival&action=afficherFestival&idFestival=<?php echo $idFestival;?>"><button type="submit" class="btn fondBleu">Modifier le Festival</button></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
            }
            ?>
            <div class="pagination">
                <?php for($page = 1; $page <= $nbPages; $page++) { ?>
                    <a href="/festiplan?controller=Home&page=<?php echo $page;?>&afficher=<?php echo $afficher;?>"><?php echo $page;?>   </a>
                <?php } ?>
            </div>
            <?php
        } else {
            echo '<div class="col-12">';
                echo '<div class="centre">';
                    echo 'Pas de spectacle créer pour le moment';
                echo '</div>';
            echo '</div>';
        }
        }
    ?>
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-12 col-md-4">
                <a href="/festiplan?controller=Spectacle"><button type="submit" class="btn btnModif fondVert">Créer un spectacle</button></a>
            </div>
            <div class="col-12 col-md-4">
                <a href="/festiplan?controller=Accueil&action=<?php if ($afficher) {echo 'voirFestival';} else { echo 'VoirSpectacle';}?>"><button type="submit" class="btn btnModif fondGris"><?php if ($afficher) {echo 'Voir mes festivals';} else { echo 'Voir mes spectacles';}?></button></a>
            </div>
            <div class="col-12 col-md-4">
                <a href="/festiplan?controller=Festival"><button type="submit" class="btn btnModif fondVert">Créer un festival</button></a>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>