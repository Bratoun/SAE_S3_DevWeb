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
        <title>Planification</title>
        <link href="static/bootstrap-4.6.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="static/css/index.css"/>
        <link href="static/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet">
    </head>
    <header>
        <div class="container-fluid header">
            <div class="row">
                <div class="col-2">
                    <a href="index.php">
                        <img src="static/images/logo_noir.png" alt="Logo Festiplan" class="logo-festiplan">
                    </a>
                </div>
                <div class="col-8">
                    <h2 class="texteCentre blanc bas"> Parametrage de la plannification : </h2>
                </div>
                <div class="col-2">
                    <button class="btn icone-user"><span class="fas fa-solid fa-user"></span></button>
                </div>
            </div>
        </div>
    </header>
    <body class="body-blanc">
        <?php
        if($message != null) echo $message;?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <?php
                        $dateCourrante = $dateDebut;
                        $i = 0;
                        while ($dateCourrante <= $dateFin)
                        {
                            $estDefini = in_array($dateCourrante, $listeDatesSauvegardees);
                            ?>
                            <a class="case-jour <?php if($estDefini) {echo "case-jour-initialisee";}else{ echo "case-jour-non-initialisee";}?>" href="/festiplan?controller=Grij&action=selectionnerJour&dateDuJour=<?php echo $dateCourrante->format('d/m/Y');?>&idFestival=<?php echo $idFestival;?>">
                                <div class="col-3">
                                    <?php
                                    echo $dateCourrante->format('d/m/Y');
                                    if ($estDefini) {
                                        echo "Début : ".$listeHeureDebut[$i];
                                        echo "Fin : ".$listeHeureFin[$i];
                                        echo "Espacement : ".$listeEcartEntreSpectacles[$i];
                                    }?>
                                </div>
                            </a>
                            <?php
                            $dateCourrante->add(new DateInterval('P1D'));
                            $i++;
                        }
                        ?> 
                    </div>
                </div>
                <div class="col-4">
                    <div class="fixed-position" id="parametres-grij">
                    <?php
                    if ($dateDuJour != null)
                    {
                        ?>
                        <form method="get" action="index.php">
                            <div class="row">
                                <input type="hidden" name="controller" value="Grij">
                                <input type="hidden" name="action" value="modifierUnJour">
                                <input type="hidden" name="dateDuJour" value="<?php echo $dateDuJour;?>">
                                <input type="hidden" name="idFestival" value="<?php echo $idFestival;?>"> 
                                <div class="col-12">
                                    <label for="heureDebut">Heure de début :</label>
                                </div>
                                <div class="col-12">
                                    <input type="time" name="heureDebut" value="<?php echo $heureDebut;?>"/>
                                </div>
                                <div class="col-12">
                                    <label for="heureFin">Heure de fin :</label>
                                </div>
                                <div class="col-12">
                                    <input type="time" name="heureFin" value="<?php echo $heureFin;?>"/>
                                </div>
                                <div class="col-12">
                                    <label for="ecartEntreSpectacles">Écart entre chaque spectacle :</label>
                                </div>
                                <div class="col-12">
                                    <input type="time" name="ecartEntreSpectacles" value="<?php echo $ecartEntreSpectacles;?>">
                                </div>
                            </div>
                            <div class="row">
                                <!-- Bouton de suppression du jour sélectionné -->
                                <?php
                                if ($heureDebut != null && $heureFin != null && $ecartEntreSpectacles != null) { ?>
                                    <div class="col-4">
                                        <a href="/festiplan?controller=Grij&action=supprimerJour&idFestival=<?php echo $idFestival;?>&dateDuJour=<?php echo $dateDuJour;?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                    </div>
                                    <?php
                                } ?>
                                <!-- Enregistre les paramètres du jour sélectionné -->
                                <div class="col-4">
                                    <input type="submit" class="btn btn-success" value="Valider"/>
                                </div>
                                <!-- Annule les modification du jour sélectionné -->
                                <div class="col-4">
                                    <a href="/festiplan?controller=Grij&action=deselectionnerJour&idFestival=<?php echo $idFestival;?>"><button type="button" class="btn btn-warning">Annuler</button></a>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <h1>Sélectionner un jour</h1>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                    <div class="">
            </div>
        </div>
    </body>
</html>