<?php

namespace controleurs;

use PDO;
use yasmf\View;
use modeles\FesitvalModele;

class CreerFestivalControleur {

    private FestivalModele $festivalModele;

    public function __construct(FestivalModele $festivalModele) {
        $this->festivalModele = $festivalModele;
    }

    public function index() {
        $searchStmt = $this->FestivalModele->listeCategorieSpectacle($pdo);
        $categorie = $searchStmt->fetch();
        $vue = new View("vues/vue_creer_festival");
        $vue->setVar("categorie",$categorie);
        return $vue;
    }
}