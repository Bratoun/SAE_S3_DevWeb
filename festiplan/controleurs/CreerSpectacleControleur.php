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

    public function nouveauSpectacle(PDO $pdo) : View
    {
        //Récupère tous les paramètres d'un spectacle
        $nom = HttpHelper::getParam('titre');
        $description = HttpHelper::getParam('description');
        $duree = HttpHelper::getParam('duree');
        $categorie = HttpHelper::getParam('categorie');
        $taille = HttpHelper::getParam('taille');
        $illustration = 'aaa';
        // Insere ce festival dans la base de données
        $search = $this->spectacleModele->insertionspectacle($pdo, $nom, $description, $duree, $illustration, $categorie, $taille);
        $vue = new View("vues/vue_accueil");
        return $vue;

    }
}