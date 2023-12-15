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
        $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
        $search_stmt = $this->spectacleModele->listeTailleScene($pdo);
        $vue = new View("vues/vue_creer_spectacle");
        $vue->setVar('searchStmt',$searchStmt);
        $vue->setVar('search_stmt',$search_stmt);
        return $vue;
    }
}