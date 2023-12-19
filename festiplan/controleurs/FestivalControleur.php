<?php

namespace controleurs;

use PDO;
use yasmf\View;
use yasmf\HttpHelper;
use modeles\FestivalModele;
use modeles\SpectacleModele;

class FestivalControleur {

    private SpectacleModele $spectacleModele;

    private FestivalModele $festivalModele;

    public function __construct(SpectacleModele $spectacleModele, FestivalModele $festivalModele) {
        $this->spectacleModele = $spectacleModele;
        $this->festivalModele = $festivalModele;
    }

    public function index(PDO $pdo) : View {
        // Met tout les champs en rouge lorsqu'on arrive sur la page
        $verifNom = false;
        $verifDesc = false;
        $verifDate = false;
        // Recherche les différentes catégories
        $searchStmt = $this->festivalModele->listeCategorieFestival($pdo);
        $vue = new View("vues/vue_creer_festival");
        // Met a false toutes les champs de création du festival
        $vue->setVar("nomOk", $verifNom);
        $vue->setVar("descOk", $verifDesc);
        $vue->setVar("dateOk", $verifDate);
        $vue->setVar("searchStmt",$searchStmt);
        return $vue;
    }

    public function nouveauOuModificationFestival(PDO $pdo) : View {
        session_start();
        // Récupere tout les parametre d'un festival
        $nom = HttpHelper::getParam('nom');
        $description = HttpHelper::getParam('description');
        $dateDebut = HttpHelper::getParam('dateDebut');
        $dateFin = HttpHelper::getParam('dateFin');
        $categorie = HttpHelper::getParam('categorie');
        $img = "aaa";
        
        // Récupere true si on modifier un festival, false si on en créer un
        $modifier = HttpHelper::getParam('modifier');
        $verifNom = false;
        $verifDesc = false;
        $verifDate = false;
        // Verifie que le nom du festival fais moins de 36 carac et sois différent de vide
        if (strlen($nom) <= 35 && trim($nom) != "") {
            $verifNom = true;
        }
        // Verifie que la description du festival fais moins de 1001 carac et sois différent de vide
        if (strlen($description) <= 1000 && trim($description) != "") {
            $verifDesc = true;
        }
        // Verifie que la date de fin du festival sois plus tard que celle de début
        if ($dateFin > $dateDebut) {
            $verifDate = true;
        }

        // Si toute les valeurs sont correctes ajoute le festival a la base de données
        if ($verifDate && $verifDesc && $verifNom) {
            // Recupere l'id de l'utilisateur courant
            $idOrganisateur = $_SESSION['id_utilisateur'];
            // Insere ce festival dans la base de données ou le modifie selon la valeur de $modifier
            if ($modifier == 'true') {
                $idFestival = HttpHelper::getParam('idFestival');
                $modification = $this->festivalModele->modificationFestival($pdo, $nom, $description, $dateDebut, $dateFin, $categorie, $img, $idFestival);
            } else {
                $insertion = $this->festivalModele->insertionFestival($pdo, $nom, $description, $dateDebut, $dateFin, $categorie, $img, $idOrganisateur);
            }

            // Renvoie a la page d'accueil avec l'affichage des festival et des spectacles de l'utilisateur
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idOrganisateur);
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idOrganisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            return $vue;
        } else {
            // Si des valeurs sont incorectes renvoie lesquels le sont et les valeurs
            $searchStmt = $this->festivalModele->listeCategorieFestival($pdo);
            // Renvoie a la vue de modification ou de création selon le cas
            if ($modifier == 'true') {
                $vue = new View("vues/vue_modifier_festival");
            } else {
                $vue = new View("vues/vue_creer_festival");
            }
            $vue->setVar("nomOk", $verifNom);
            $vue->setVar("ancienNom", $nom);
            $vue->setVar("descOk", $verifDesc);
            $vue->setVar("ancienneDesc", $description);
            $vue->setVar("dateOk", $verifDate);
            $vue->setVar("ancienneDateDebut", $dateDebut);
            $vue->setVar("ancienneDateFin", $dateFin);
            $vue->setVar("ancienneCategorie", $categorie);
            $vue->setVar("searchStmt",$searchStmt);
            return $vue;
        }
    }

    public function afficherFestival(PDO $pdo) : View {
        session_start();

        $idOrganisateur = $_SESSION['id_utilisateur'];
        $idFestival = HttpHelper::getParam('idFestival');

        // Recupere si l'utilisateur et le responsable du festival
        $estResponsable = $this->festivalModele->estResponsable($pdo,$idFestival,$idOrganisateur);
        // Recupere les données du festival séléctionné
        $festivalAModifier = $this->festivalModele->leFestival($pdo,$idFestival);
        // Recupere les données de la liste des catégorie
        $searchStmt = $this->festivalModele->listeCategorieFestival($pdo);
        // Recupere l'ensemble des organisateur actuel du festival
        $listeOrganisateur = $this->festivalModele->listeOrganisateurFestival($pdo,$idFestival);
        // Mets les données dans la vue
        $vue = new View("vues/vue_modifier_festival");
        $vue->setVar("nomOk", true);
        $vue->setVar("ancienNom", $festivalAModifier['titre']);
        $vue->setVar("descOk", true);
        $vue->setVar("ancienneDesc", $festivalAModifier['description']);
        $vue->setVar("dateOk", true);
        $vue->setVar("ancienneDateDebut", $festivalAModifier['dateDebut']);
        $vue->setVar("ancienneDateFin", $festivalAModifier['dateFin']);
        $vue->setVar("ancienneCategorie", $festivalAModifier['categorie']);
        $vue->setVar("idFestival", $idFestival);
        $vue->setVar("searchStmt",$searchStmt);
        $vue->setVar("estResponsable", $estResponsable['responsable']);
        $vue->setVar("listeOrganisateur", $listeOrganisateur);
        return $vue;
    }

    public function supprimerFestival(PDO $pdo) : View {
        session_start();

        $idOrganisateur = $_SESSION['id_utilisateur'];
        $idFestival = HttpHelper::getParam('idFestival');

        // Supprime le festival de la base de données
        $supprimerFestival = $this->festivalModele->supprimerFestival($pdo, $idFestival);

        // Renvoie a l'accueil sans le festival que l'on a supprimer
        $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idOrganisateur);
        $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idOrganisateur);
        $vue = new View("vues/vue_accueil");
        $vue->setVar("mesSpectacles", $mesSpectacles);
        $vue->setVar("mesFestivals", $mesFestivals);
        return $vue;
    }

    public function ajouterOrganisateur(PDO $pdo) : View {
        session_start();
        $idOrganisateur = $_SESSION['id_utilisateur'];
        $idFestival = HttpHelper::getParam('idFestival');

        $vue = new View("vues/vue_ajouter_organisateur");
    }
}