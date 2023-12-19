<?php

namespace controleurs;

use PDO;
use yasmf\View;
use yasmf\HttpHelper;
use modeles\SpectacleModele;
use modeles\FestivalModele;

class SpectacleControleur {

    private SpectacleModele $spectacleModele;

    private FestivalModele $festivalModele;

    public function __construct(SpectacleModele $spectacleModele, FestivalModele $festivalModele) {
        $this->spectacleModele = $spectacleModele;
        $this->festivalModele = $festivalModele;
    }

    public function index(PDO $pdo): View {
        // Met tout les champs en rouge lorsqu'on arrive sur la page
        $verifTitre = false;
        $verifDesc = false;
        $verifDuree = false;
        // Recherche les différentes catégories
        $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
        $search_stmt = $this->spectacleModele->listeTailleScene($pdo);
        $vue = new View("vues/vue_creer_spectacle");
        $vue->setVar('searchStmt',$searchStmt);
        $vue->setVar('search_stmt',$search_stmt);
        return $vue;
    }

    public function nouveauSpectacle(PDO $pdo) : View
    {   
        session_start();
        //Récupère tous les paramètres d'un spectacle
        $titre = HttpHelper::getParam('titre');
        $description = HttpHelper::getParam('description');
        $duree = HttpHelper::getParam('duree');
        $categorie = HttpHelper::getParam('categorie');
        $taille = HttpHelper::getParam('taille');
        $illustration = 'aaa';

        $verifTitre = false;
        $verifDesc = false;
        $verifDuree = false;
        // Verifie que le titre du spectacle fasse moins de 36 carac et sois différent de vide
        if (strlen($titre) <= 35 && trim($titre) != "") {
            $verifTitre = true;
        }
        // Verifie que la description du spectacle fasse moins de 1001 carac et sois différent de vide
        if (strlen($description) <= 1000 && trim($description) != "") {
            $verifDesc = true;
        }
        // Verifie que la durée du spectacle sois supérieure a 0 est inférieure a 3600 minutes
        if ($duree > 0 && $duree < 3600) {
            $verifDuree = true;
        }

         // Si toute les valeurs sont correctes ajoute le spectacle a la base de données
        if ($verifDuree && $verifDesc && $verifTitre) {
            // Recupere l'id de l'utilisateur
            $idUtilisateur = $_SESSION['id_utilisateur'];
            $search = $this->spectacleModele->insertionspectacle($pdo, $titre, $description, $duree, $illustration, $categorie, $taille, $idUtilisateur);
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur);
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            return $vue;
        } else {
            // Si des valeurs sont incorectes renvoie lesquels le sont et les valeurs
            $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
            $search_stmt = $this->spectacleModele->listeTailleScene($pdo);

            $vue = new View("vues/vue_creer_spectacle");
            $vue->setVar("titreOk", $verifTitre);
            $vue->setVar("ancienTitre", $titre);
            $vue->setVar("descOk", $verifDesc);
            $vue->setVar("ancienneDesc", $description);
            $vue->setVar("dureeOk", $verifDuree);
            $vue->setVar("ancienneDuree", $duree);
            $vue->setVar("ancienneCategorie", $categorie);
            $vue->setVar("ancienneTaille", $taille);

            $vue->setVar('searchStmt',$searchStmt);
            $vue->setVar('search_stmt',$search_stmt);
            return $vue;
        }
    }

    public function afficherSpectacle(PDO $pdo) : View {
        session_start();

        $idOrganisateur = $_SESSION['id_utilisateur'];
        $idSpectacle = HttpHelper::getParam('idSpectacle');

        // Recupere les données du spectacle séléctionné
        $spectacleAModifier = $this->spectacleModele->leSpectacle($pdo,$idSpectacle);
        // Recupere les données de la liste des catégorie
        $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
        // Recupere les données de la liste des tailles de scènes
        $searchStmt2 = $this->spectacleModele->listeTailleScene($pdo);
        // Mets les données dans la vue
        $vue = new View("vues/vue_modifier_spectacle");
        $vue->setVar("titreOk", true);
        $vue->setVar("ancienTitre", $spectacleAModifier['titre']);
        $vue->setVar("descOk", true);
        $vue->setVar("ancienneDesc", $spectacleAModifier['description']);
        $vue->setVar("dureeOk",true);
        $vue->setVar("ancienneDuree", $spectacleAModifier['duree']);
        $vue->setVar("ancienneCategorie", $spectacleAModifier['categorie']);
        $vue->setVar("ancienneTaille", $spectacleAModifier['tailleSceneRequise']);
        $vue->setVar("idSpectacle", $idSpectacle);

        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("searchStmt2",$searchStmt2);
        return $vue;
    }
}