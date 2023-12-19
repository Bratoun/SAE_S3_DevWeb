<?php

namespace controleurs;

use PDO;
use DateTime;
use yasmf\View;
use yasmf\HttpHelper;
use modeles\GrijModele;

class GrijControleur
{
    private GrijModele $grijModele;
    
    public function __construct(GrijModele $grijModele)
    {
        $this->grijModele = $grijModele;
    }

    public function index(PDO $pdo)
    {
        $idFestival = HttpHelper::getParam('idFestival');
        $message = null;
        // La page de modification sera présélectionnée sur le premier jour
        // si aucun jour n'a été sélectionné.
        $dateDuJour = HttpHelper::getParam('dateDuJour');

        $vue = new View("vues/vue_parametres_grij");

        $this->initialiserVariableTab($vue, $pdo, $idFestival);

        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('dateDuJour', $dateDuJour);
        $vue->setVar('message', $message);
        return $vue;
    }

    private function afficherListeJour(PDO $pdo, $idFestival)
    {
        $searchStmt = $this->grijModele->recupererDatesParIdFestival($pdo, $idFestival);
        $row = $searchStmt->fetch();
        return $row;
    }

    public function modifierUnJour(PDO $pdo)
    {
        $message=null;
        $heureDebut = HttpHelper::getParam('heureDebut');
        $heureFin = HttpHelper::getParam('heureFin');
        $ecartEntreSpectacles = HttpHelper::getParam('ecartEntreSpectacles');
        $dateDuJour = HttpHelper::getParam('dateDuJour');
        $idFestival = HttpHelper::getParam('idFestival');

        if ($heureDebut == null || $heureFin == null || $ecartEntreSpectacles == null
        && !($heureDebut==null && $heureFin==null && $ecartEntreSpectacles==null)) {
            $message = "vous n'avez pas remplis tous les champs";
        } else {
            $this->grijModele->modifierOuAjouterJour($pdo,$heureDebut, $heureFin, $ecartEntreSpectacles, $idFestival, $dateDuJour);
        }
        


        $vue = new View("vues/vue_parametres_grij");

        $this->initialiserVariableTab($vue, $pdo, $idFestival);
        $vue->setVar('dateDuJour', $dateDuJour);
        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('heureDebut', $heureDebut);
        $vue->setVar('heureFin', $heureFin);
        $vue->setVar('ecartEntreSpectacles', $ecartEntreSpectacles);
        $vue->setVar('message', $message);
        return $vue;
    }

    public function selectionnerJour(PDO $pdo)
    {
        $dateDuJour = HttpHelper::getParam('dateDuJour');
        $idFestival = HttpHelper::getParam('idFestival');
        $message = null;

        $vue = new View("vues/vue_parametres_grij");

        $this->initialiserVariableTab($vue, $pdo, $idFestival);

        $jour = $this->grijModele->recupererJourParDateEtFestival($pdo, $dateDuJour, $idFestival);
        $row = $jour->fetch();
        if ($row != false)
        {
            $vue->setVar('heureDebut', $row['heureDebut']);
            $vue->setVar('heureFin', $row['heureFin']);
            $vue->setVar('ecartEntreSpectacles', $row['tempsEntreSpectacle']);
        }

        $vue->setVar('dateDuJour', $dateDuJour);
        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        return $vue;
    }

    public function deselectionnerJour(PDO $pdo)
    {
        $idFestival = HttpHelper::getParam('idFestival');
        $message = null;
        $vue = new View("vues/vue_parametres_grij");
        $this->initialiserVariableTab($vue, $pdo, $idFestival);
        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        return $vue;
    }

    public function supprimerJour(PDO $pdo)
    {
        $message=null;
        $dateDuJour = HttpHelper::getParam('dateDuJour');
        $idFestival = HttpHelper::getParam('idFestival');

        $this->grijModele->supprimerJour($pdo,$idFestival,$dateDuJour);

        $vue = new View("vues/vue_parametres_grij");

        $this->initialiserVariableTab($vue, $pdo, $idFestival);

        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        return $vue;
    }

    private function initialiserVariableTab(View $vue, PDO $pdo, $idFestival)
    {
        $searchStmt = $this->grijModele->recupererDatesParIdFestival($pdo, $idFestival);
        $row = $searchStmt->fetch();

        $stringDatesSauvegardees = $row['datesAssociees'];
        $listeDatesSauvegardees = explode(',', $stringDatesSauvegardees);
        $listeFinaleDate = array();
        foreach($listeDatesSauvegardees as $date)
        {
            $listeFinaleDate[] = new DateTime($date);
        }

        $listeHeureDebut = explode(',', $row['heureDebut']);
        $listeHeureFin = explode(',', $row['heureFin']);
        $listeEcart = explode(',', $row['tempsEntreSpectacle']);

        $vue->setVar('listeDatesSauvegardees', $listeFinaleDate);
        $vue->setVar('dateDebut', new DateTime($row['dateDebut']));
        $vue->setVar('dateFin', new DateTime($row['dateFin']));
        $vue->setVar('listeHeureDebut', $listeHeureDebut);
        $vue->setVar('listeHeureFin', $listeHeureFin);
        $vue->setVar('listeEcartEntreSpectacles', $listeEcart);
    }
}