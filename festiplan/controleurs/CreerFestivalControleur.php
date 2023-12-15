<?php

namespace controleurs;

use PDO;
use yasmf\View;
use yasmf\HttpHelper;
use modeles\FestivalModele;

class CreerFestivalControleur {

    private FestivalModele $festivalModele;

    public function __construct(FestivalModele $festivalModele) {
        $this->festivalModele = $festivalModele;
    }

    public function index(PDO $pdo) : View {
         // Vérifier si l'utilisateur est connecté
        session_start();
        if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
            $searchStmt = $this->festivalModele->listeCategorieFestival($pdo);
            $vue = new View("vues/vue_creer_festival");
            $vue->setVar("searchStmt",$searchStmt);
            return $vue;
        } else {
            return new View("vues/vue_connexion");
        }
    }

    public function nouveauFestival(PDO $pdo) : View {
        // Récupere tout les parametre d'un festival
        $nom = HttpHelper::getParam('nom');
        $description = HttpHelper::getParam('description');
        $dateDebut = HttpHelper::getParam('dateDebut');
        $dateFin = HttpHelper::getParam('dateFin');
        $cate = HttpHelper::getParam('cate');
        $img = "aaa";
        $idOrganisateur = $_SESSION['id_utilisateur'];
        // Insere ce festival dans la base de données
        $searchStmt = $this->festivalModele->insertionFestival($pdo, $nom, $description, $dateDebut, $dateFin, $cate, $img, $idOrganisateur);
        $vue = new View("vues/vue_accueil");
        return $vue;
    }
}