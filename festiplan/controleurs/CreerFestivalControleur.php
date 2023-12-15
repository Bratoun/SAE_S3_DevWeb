<?php

namespace controleurs;

use PDO;
use yasmf\View;

class CreerFestivalControleur {

    private FestivalModele $FestivalModele;

    public function __construct() {
    }

    public function index() {
        $searchStmt = $this->FestivalModele->listeCategorieSpectacle($pdo);
        $categorie = $searchStmt->fetch();
        $vue = new View("vues/vue_creer_festival");
        $vue->setVar("categorie",$categorie);
        return $vue;
    }
}