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
        $ecartEntreSpectacles =HttpHelper::getParam('ecartEntreSpectacles');

        if ($heureDebut == null || $heureFin == null || $ecartEntreSpectacles == null){
            $vue = new View('vues/vue_parametres_grij');
            $message = "Vous n'avez pas entré tous les champs";
            $this->initialiseHeuresSelectionnees($vue, $heureDebut, $heureFin, $ecartEntreSpectacles);
        
        } else if (strtotime($heureDebut)> strtotime($heureFin)) {
            $vue = new View('vues/vue_parametres_grij');
            $message = "La date de fin est plus petite que celle de début.<br>Il faut entrer une date de fin plus grande";
            $this->initialiseHeuresSelectionnees($vue, $heureDebut, $heureFin, $ecartEntreSpectacles);
        
        } else if ($this->convertirEnMinutes($ecartEntreSpectacles)
          >= ($this->convertirEnMinutes($heureFin) - $this->convertirEnMinutes($heureDebut))) {
            $vue = new View('vues/vue_parametres_grij');
            $message = "L'écart entre les spectacles est supérieur à la durée totale";
            $this->initialiseHeuresSelectionnees($vue, $heureDebut, $heureFin, $ecartEntreSpectacles);
        
        } else {
            $ok = $this->grijModele->modifierCreerGrij($pdo, $idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles);
            if ($ok){
                $stmt = $this->grijModele->recupererJours($pdo, $idFestival);

                // Récupération des spectacles
                $spectacles = $this->grijModele->recupererSpectacles($pdo, $idFestival);
                // Récupération des scenes
                $scenes = $this->grijModele->recupererScenes($pdo, $idFestival);

                // TODO classer les spectacles dans les jours

                $vue = new View('vues/vue_consultation_planification');
                $vue->setVar('listeJours', $stmt);
            } else {
                $vue = new View('vues/vue_parametres_grij');
                $message = "Erreur avec la base de données.";
                $this->initialiseHeuresSelectionnees($vue, $heureDebut, $heureFin, $ecartEntreSpectacles);
            }
        }

        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        return $vue;
    }

    private function convertirEnMinutes($heure) {
        $temps = explode(":", $heure);
        return $temps[0] * 60 + $temps[1];
    }

    private function initialiseHeuresSelectionnees($vue, $debut, $fin, $ecart)
    {
        $vue->setVar('heureDebut', $debut);
        $vue->setVar('heureFin', $fin);
        $vue->setVar('ecartEntreSpectacles', $ecart);
    }

    private function planifierSpectacles($spectacles, $scenes, $heureDebut, $heureFin, $ecartEntreSpectacles, $jours)
    {
        $dureeTotal = $heureFin - $heureDebut;
        $dureeTotal = $this->convertirEnMinutes($dureeTotal);
        $i = 0;
        $spectacleOk = ;
        while ($jours->fetch() && ) {
            $ordre = 0;
            $duree = 0;
            while($duree < $dureeTotal) {
                $
            }
        }
    }

}