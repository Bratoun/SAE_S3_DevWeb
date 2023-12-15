<?php

namespace controleurs;

use PDO;
use yasmf\View;
use modeles\spectacleModele;

class CreerSpectacleControleur {
    private SpectacleModele $spectacleModele;

    public function __construct(SpectacleModele $spectacleModele) 
    {
        $this->spectacleModele = $spectacleModele;
    }

    public function index(PDO $pdo): View {
        $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
        $vue = new View("vues/vue_creer_spectacle");
        $vue->setVar('searchStmt',$searchStmt);
        return $vue;
    }
}