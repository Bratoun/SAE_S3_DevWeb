<?php

namespace controleurs;

use PDO;
use yasmf\View;
use modeles\SpectacleModele;
use modeles\FestivalModele;


class AccueilControleur {


    public function __construct(SpectacleModele $spectacleModele, FestivalModele $festivalModele) {
        $this->spectacleModele = $spectacleModele;
        $this->festivalModele = $festivalModele;
    }

    public function index(PDO $pdo) : View {
        $afficher = false;
        $idUtilisateur = $_SESSION['id_utilisateur'];
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $pageActuelle = (int) strip_tags($_GET['page']);
        }else{
            $pageActuelle = 1;
        }
        $nbFestival = (int)$this->festivalModele->nombreMesFestivals($pdo,$idUtilisateur);
        // On calcule le nombre de pages total
        $nbPages = ceil($nbFestival / 5);
        // Calcul du 1er article de la page
        $premier = ($pageActuelle * 5) - 5;
        var_dump($premier);
        $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur,$premier);
        $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
        $vue = new View("vues/vue_accueil");
        $vue->setVar("nbPages", $nbPages);
        $vue->setVar("mesSpectacles", $mesSpectacles);
        $vue->setVar("mesFestivals", $mesFestivals);
        return $vue;
    }

    public function voirFestival(PDO $pdo) {
        session_start();
        $afficher = false;
        $idUtilisateur = $_SESSION['id_utilisateur'];
        $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
        $vue = new View("vues/vue_accueil");
        $vue->setVar("mesFestivals", $mesFestivals);
        return $vue;
    }   

    public function voirSpectacle(PDO $pdo) {
        session_start();
        $afficher = true;
        $idUtilisateur = $_SESSION['id_utilisateur'];
        $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
        $vue = new View("vues/vue_accueil");
        $vue->setVar("mesSpectacles", $mesSpectacles);
        $vue->setVar("afficher",$afficher);
        return $vue;
    }
}   