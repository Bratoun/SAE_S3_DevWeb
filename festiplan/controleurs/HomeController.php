<?php

namespace controleurs;

use PDO;
use yasmf\View;

class HomeController {

    public function __construct() {
    }

<<<<<<< Updated upstream
    public function index() {
        return new View("vues/vue_connexion");
=======
    public function index(PDO $pdo) : View{
        // Vérifier si l'utilisateur est connecté
        session_start();
        if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
            $idUtilisateur = $_SESSION['id_utilisateur'];
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("afficher", false);
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            return $vue;
        } else {
            return new View("vues/vue_connexion");
        }
>>>>>>> Stashed changes
    }
}