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

        $vue = new View('vues/vue_parametres_grij');
        $stmt = $this->grijModele->recupererParametresGrij($pdo, $idFestival);
        $row = $stmt->fetch();
        if ($row) {
            $vue->setVar('heureDebut', $row['heureDebut']);
            $vue->setVar('heureFin', $row['heureFin']);
            $vue->setVar('ecartEntreSpectacles', $row['tempsEntreSpectacle']);
        }

        $vue->setVar('idFestival', $idFestival);
        return $vue;
    }

    public function enregistrerGrij(PDO $pdo)
    {
        $message = null;
        $idFestival = HttpHelper::getParam('idFestival');
        $heureDebut = HttpHelper::getParam('heureDebut');
        $heureFin = HttpHelper::getParam('heureFin');
        $ecartEntreSpectacles = HttpHelper::getParam('ecartEntreSpectacles');

        if ($heureDebut == null || $heureFin == null || $ecartEntreSpectacles == null){
            $vue = new View('vues/vue_parametres_grij');
            $message = "Vous n'avez pas entré tous les champs";
            $vue->setVar('heureDebut', $heureDebut);
            $vue->setVar('heureFin', $heureFin);
            $vue->setVar('ecartEntreSpectacles', $ecartEntreSpectacles);
        } else {
            $vue = new View('vues/vue_consultation_planification');
            $this->grijModele->modifierCreerGrij($pdo, $idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles);
            $stmt = $this->grijModele->recupererJours($pdo, $idFestival);
            $vue->setVar('listeJours', $stmt);
        }

        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        return $vue;
    }
}