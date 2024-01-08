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
        $message = null;
        $stmt = $this->grijModele->recupererParametresGrij($pdo, $idFestival);
        $row = $stmt->fetch();
        if ($row) {
            $vue->setVar('heureDebut', $row['heureDebut']);
            $vue->setVar('heureFin', $row['heureFin']);
            $vue->setVar('ecartEntreSpectacles', $row['tempsEntreSpectacle']);
        }

        $vue->setVar('message', $message);
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

                // Récupération des jours du festival
                $jours = $this->grijModele->recupererJours($pdo, $idFestival);
                // Récupération des spectacles
                $spectacles = $this->grijModele->recupererSpectacles($pdo, $idFestival);
                // Récupération des scenes
                $scenes = $this->grijModele->recupererScenes($pdo, $idFestival);

                // création de la grij
                $this->planifierSpectacles($pdo, $idFestival,$spectacles, $scenes, $heureDebut, $heureFin, $ecartEntreSpectacles, $jours);

                $grij = $this->grijModele->recupererGrij($pdo, $idFestival);

                $vue = new View('vues/vue_consultation_planification');
                $vue->setVar('listeJours', $grij);

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

    private function planifierSpectacles(PDO $pdo, $idFestival,$spectacles, $scenes, $heureDebut, $heureFin, $ecartEntreSpectacles, $jours)
    {
        $dureeTotal = $this->convertirEnMinutes($heureFin) - $this->convertirEnMinutes($heureDebut);
        $ecart = $this->convertirEnMinutes($ecartEntreSpectacles);
        $i = 0;
        $unSpectacle = $spectacles->fetch();
        $spectacleNonPlace = false;

        while (($jour =$jours->fetch()) && $unSpectacle) {
            $ordre = 0;
            $duree = 0;
            
            if (($this->convertirEnMinutes($unSpectacle['duree'])+ $duree) <= $dureeTotal) {
                $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, $jour['idJour'],$unSpectacle['id'], null, $ordre, 1);
                $ordre++;
                $duree += $ecart;
            }

            while(($unSpectacle = $spectacles->fetch()) && $duree < $dureeTotal) {
                if (($this->convertirEnMinutes($unSpectacle['duree'])+ $duree) < $dureeTotal) {
                    $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                    $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, $jour['idJour'],$unSpectacle['id'], null, $ordre, 1);
                    $ordre++;
                    $duree += $ecart;
                } else {
                    $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                }
            }
            if($unSpectacle && $this->convertirEnMinutes($unSpectacle['duree']) > $dureeTotal) {
                $spectacleNonPlace = $unSpectacle;
                $unSpectacle = false;
            }
        }
        if ($spectacleNonPlace != null) {
            $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$spectacleNonPlace['id'], null, 0, 0);
            while ($unSpectacle = $spectacles->fetch()){
                $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], null, 0, 0);
            }
        }
    }
}