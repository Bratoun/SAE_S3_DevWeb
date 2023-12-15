<?php

namespace controleurs;

use PDO;
use yasmf\View;
use yasmf\HttpHelper;
use modeles\SpectacleModele;

class CreerSpectacleControleur {
    private SpectacleModele $spectacleModele;

    public function __construct(SpectacleModele $spectacleModele) 
    {
        $this->spectacleModele = $spectacleModele;
    }

    public function index(PDO $pdo): View {
        // Vérifier si l'utilisateur est connecté
        session_start();
        if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
            $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
            $search_stmt = $this->spectacleModele->listeTailleScene($pdo);
            $vue = new View("vues/vue_creer_spectacle");
            $vue->setVar('searchStmt',$searchStmt);
            $vue->setVar('search_stmt',$search_stmt);
            return $vue;
        } else {
            return new View("vues/vue_connexion");
        }
    }
}