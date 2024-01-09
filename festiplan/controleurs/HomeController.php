<?php

namespace controleurs;

use PDO;
use yasmf\View;
use modeles\SpectacleModele;
use modeles\FestivalModele;

class HomeController {

    private SpectacleModele $spectacleModele;

    private FestivalModele $festivalModele;

    public function __construct(SpectacleModele $spectacleModele, FestivalModele $festivalModele) {
        $this->spectacleModele = $spectacleModele;
        $this->festivalModele = $festivalModele;
    }

    public function index(PDO $pdo) : View{
        // Vérifier si l'utilisateur est connecté
        session_start();
        if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
            $idUtilisateur = $_SESSION['id_utilisateur'];
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            return $vue;
        } else {
            $verifLoginOuMdp = true;
            $vue = new View("vues/vue_connexion");
            $vue->setVar("loginOuMdpOk", $verifLoginOuMdp);
            return $vue;
        }
    }
}