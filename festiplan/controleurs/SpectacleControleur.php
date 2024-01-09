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
        $vue->setVar("titreOk", $verifTitre);
        $vue->setVar("descOk", $verifDesc);
        $vue->setVar("dureeOk", $verifDuree);
        $vue->setVar("categorieOk", $verifCategorie);
        $vue->setVar("tailleOk",$verifTaille);
        $vue->setVar("ancienneCategorie", " ");
        $vue->setVar("ancienneTaille", " ");
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

        // Récupere true si on modifier un spectalce, false si on en créer un
        $modifier = HttpHelper::getParam('modifier');

        $verifTitre = false;
        $verifDesc = false;
        $verifDuree = false;
        $verifTaille = false;
        $verifCategorie = false;
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

        if ($taille != 0) {
            $verifTaille = true;
        }

        if ($categorie != 0) {
            $verifCategorie = true;
        }

         // Si toute les valeurs sont correctes ajoute le spectacle a la base de données
        if ($verifDuree && $verifDesc && $verifTitre && $verifTaille && $verifCategorie) {
            // Recupere l'id de l'utilisateur
            $idUtilisateur = $_SESSION['id_utilisateur'];
            // Insere ce spectacle dans la base de données ou le modifie selon la valeur de $modifier
            if ($modifier == 'true') {
                $idSpectacle = HttpHelper::getParam('idSpectacle');
                $modif = $this->spectacleModele->modifspectacle($pdo, $titre, $description, $duree, $illustration, $categorie, $taille, $idSpectacle);
            } else {
                $search = $this->spectacleModele->insertionspectacle($pdo, $titre, $description, $duree, $illustration, $categorie, $taille, $idUtilisateur);
            }

            //Renvoie à l'accueil car quand il va à la pgae connexion il est déjà connecté
            $vue = new View("vues/vue_connexion");
            return $vue;
        } else {
            // Si des valeurs sont incorectes renvoie lesquels le sont et les valeurs
            $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
            $search_stmt = $this->spectacleModele->listeTailleScene($pdo);
            if ($modifier == 'true') {
                $vue = new View("vues/vue_modifier_spectacle");
            } else {
                $vue = new View("vues/vue_creer_spectacle");
            }
            $vue->setVar("titreOk", $verifTitre);
            $vue->setVar("ancienTitre", $titre);
            $vue->setVar("descOk", $verifDesc);
            $vue->setVar("ancienneDesc", $description);
            $vue->setVar("dureeOk", $verifDuree);
            $vue->setVar("ancienneDuree", $duree);
            $vue->setVar("categorieOk", $verifCategorie);
            $vue->setVar("tailleOk",$verifTaille);
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
        // Recupere la liste des intervenants 
        $searchStmt3 = $this->spectacleModele->nomIntervenantSurScene($pdo,$idSpectacle);
        // Recupere la liste des intervenants hors scene 
        $searchStmt4 = $this->spectacleModele->nomIntervenantHorsScene($pdo,$idSpectacle);
        // Mets les données dans la vue
        $vue = new View("vues/vue_modifier_spectacle");
        $vue->setVar("titreOk", true);
        $vue->setVar("ancienTitre", $spectacleAModifier['titre']);
        $vue->setVar("descOk", true);
        $vue->setVar("ancienneDesc", $spectacleAModifier['description']);
        $vue->setVar("dureeOk",true);
        $vue->setVar("categorieOk", true);
        $vue->setVar("tailleOk", true);
        $vue->setVar("ancienneDuree", $spectacleAModifier['duree']);
        $vue->setVar("ancienneCategorie", $spectacleAModifier['categorie']);
        $vue->setVar("ancienneTaille", $spectacleAModifier['tailleSceneRequise']);
        $vue->setVar("idSpectacle", $idSpectacle);

        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("searchStmt2",$searchStmt2);
        $vue->setVar("searchStmt3",$searchStmt3);
        $vue->setVar("searchStmt4",$searchStmt4);
        return $vue;
    }

    public function ajouterIntervenant(PDO $pdo) : View {
        $idSpectacle = HttpHelper::getParam('idSpectacle');
        // Recupere les données de la liste des métiers des intervenants
        $searchStmt = $this->spectacleModele->listeMetiersIntervenants($pdo);
        $vue = new View("vues/vue_ajouter_intervenant");
        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("idSpectacle",$idSpectacle);
        return $vue;
    }
    
    public function modifierIntervenant(PDO $pdo) : View {
        $idIntervenant = HttpHelper::getParam('intervenant');
        $idSpectacle = HttpHelper::getParam('idSpectacle');
        // Recupere les données de la liste des métiers des intervenants
        $searchStmt = $this->spectacleModele->listeMetiersIntervenants($pdo);
        $vue = new View("vues/vue_modifier_intervenant");
        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("idIntervenant",$idIntervenant);
        $vue->setVar("idSpectacle",$idSpectacle);
        return $vue;
    }

    public function nouveauIntervenant(PDO $pdo) : View {
        //Récupère tous les paramètres d'un intervenant
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $mail = HttpHelper::getParam('email');
        $surScene = HttpHelper::getParam('categorieIntervenant');
        $typeIntervenant = HttpHelper::getParam('metierIntervenant');
        $idSpectacle = HttpHelper::getParam('idSpectacle');
        
        $search = $this->spectacleModele->insertionsIntervenants($pdo, $idSpectacle, $nom, $prenom, $mail, $surScene, $typeIntervenant);
        
        // Recupere les données du spectacle séléctionné
        $spectacleAModifier = $this->spectacleModele->leSpectacle($pdo,$idSpectacle);
        // Recupere les données de la liste des catégorie
        $searchStmt = $this->spectacleModele->listeCategorieSpectacle($pdo);
        // Recupere les données de la liste des tailles de scènes
        $searchStmt2 = $this->spectacleModele->listeTailleScene($pdo);
        // Recupere la liste des intervenants 
        $searchStmt3 = $this->spectacleModele->nomIntervenantSurScene($pdo,$idSpectacle);
        // Recupere la liste des intervenants hors scene 
        $searchStmt4 = $this->spectacleModele->nomIntervenantHorsScene($pdo,$idSpectacle);
        // Mets les données dans la vue
        $vue = new View("vues/vue_modifier_spectacle");
        $vue->setVar("titreOk", true);
        $vue->setVar("ancienTitre", $spectacleAModifier['titre']);
        $vue->setVar("descOk", true);
        $vue->setVar("ancienneDesc", $spectacleAModifier['description']);
        $vue->setVar("dureeOk",true);
        $vue->setVar("categorieOk", true);
        $vue->setVar("tailleOk",true);
        $vue->setVar("ancienneDuree", $spectacleAModifier['duree']);
        $vue->setVar("ancienneCategorie", $spectacleAModifier['categorie']);
        $vue->setVar("ancienneTaille", $spectacleAModifier['tailleSceneRequise']);
        $vue->setVar("idSpectacle", $idSpectacle);

        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("searchStmt2",$searchStmt2);
        $vue->setVar("searchStmt3",$searchStmt3);
        $vue->setVar("searchStmt4",$searchStmt4);
        return $vue;
    }

    
    public function supprimerSpectacle(PDO $pdo) : View {
        session_start();

        $idOrganisateur = $_SESSION['id_utilisateur'];
        $idSpectacle = HttpHelper::getParam('idSpectacle');

        // Supprime le festival de la base de données
        $supprimerSpectacle = $this->spectacleModele->supprimerSpectacle($pdo, $idSpectacle);

        // Renvoie a l'accueil sans le festival que l'on a supprimer
        $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idOrganisateur);
        $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idOrganisateur);
        $vue = new View("vues/vue_accueil");
        $vue->setVar("mesSpectacles", $mesSpectacles);
        $vue->setVar("mesFestivals", $mesFestivals);
        return $vue;
    }

    public function supprimerIntervenant(PDO $pdo) {

    }
}