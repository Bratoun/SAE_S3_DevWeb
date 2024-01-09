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
        
        $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
        $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
        $vue = new View("vues/vue_accueil");
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