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
                $scenes = $scenes->fetchAll();
                // création de la grij
                $this->planifierSpectacles($pdo, $idFestival,$spectacles, $scenes, $heureDebut, $heureFin, $ecartEntreSpectacles, $jours);

                $grij = $this->grijModele->recupererGrij($pdo, $idFestival);
                $spectacleNonPlace = $this->grijModele->recupererSpectacleNonPlace($pdo,$idFestival);

                $vue = new View('vues/vue_consultation_planification');
                $vue->setVar('listeSpectacleNonPlace', $spectacleNonPlace);
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

        while (($jour = $jours->fetch()) && $unSpectacle) {
            $ordre = 0;
            $duree = 0;
            $leJourContinue = true;
            $spectacleNonPlace = null;
            
            if (($this->convertirEnMinutes($unSpectacle['duree'])+ $duree) <= $dureeTotal) {
                $scenesAdequates = $this->grijModele->recuperationSceneAdequate($pdo, $idFestival,$unSpectacle['taille']);
                $heureDebutSpectacle = $this->convertirMinutesEnHeuresMySQL($duree + $this->convertirEnMinutes($heureDebut));
                $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                $heureFinSpectacle = $this->convertirMinutesEnHeuresMySQL($duree + $this->convertirEnMinutes($heureDebut));
                if ($scenesOk = $scenesAdequates->fetchAll()) {
                    $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, $jour['idJour'],$unSpectacle['id'], $ordre, 1,$heureDebutSpectacle,$heureFinSpectacle,null);
                    $this->grijModele->insertionSpectacleScene($pdo, $idFestival, $unSpectacle['id'], $scenesOk);
                } else {
                    $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], $ordre, 0,null,null);
                }
                $ordre++;
                $duree += $ecart;
            }

            while($leJourContinue && ($unSpectacle = $spectacles->fetch()) && $duree < $dureeTotal) {
                if (($this->convertirEnMinutes($unSpectacle['duree'])+ $duree) < $dureeTotal) {
                    $heureDebutSpectacle = $this->convertirMinutesEnHeuresMySQL($duree + $this->convertirEnMinutes($heureDebut));
                    $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                    $heureFinSpectacle = $this->convertirMinutesEnHeuresMySQL($duree + $this->convertirEnMinutes($heureDebut));
                    $scenesAdequates = $this->grijModele->recuperationSceneAdequate($pdo, $idFestival,$unSpectacle['taille']);
                    $scenesOk = $scenesAdequates->fetchAll();
                    if ($scenesOk) {
                        $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, $jour['idJour'],$unSpectacle['id'], $ordre, 1,$heureDebutSpectacle,$heureFinSpectacle,null);
                        $this->grijModele->insertionSpectacleScene($pdo, $idFestival, $unSpectacle['id'], $scenesOk);
                    } else {
                        $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], 0, 0,null,null,3);
                    }
                    $ordre++;
                    $duree += $ecart;
                } else {
                    $leJourContinue  = false;
                    $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                    $spectacleNonPlace = $unSpectacle;
                }
            }
            if($unSpectacle && $this->convertirEnMinutes($unSpectacle['duree']) > $dureeTotal) {
                $spectacleNonPlace = $unSpectacle;
                $unSpectacle = false;
            }
        }
        if ($spectacleNonPlace != null) {
            $causeNonPlace = null;
            if($jour != false) {
                $causeNonPlace = 1;
            } else {
                $causeNonPlace = 2;
            }
            $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$spectacleNonPlace['id'], 0, 0,null,null,$causeNonPlace);
            while ($unSpectacle = $spectacles->fetch()){
                $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], 0, 0,null,null,$causeNonPlace);
            }
        }
    }

    public function profilSpectacleJour(PDO $pdo)
    {
        $message = null;
        $idFestival = HttpHelper::getParam('idFestival');
        $idSpectacle = HttpHelper::getParam('idSpectacle');

        $listeScenes = $this->grijModele->recupererListeScenes($pdo,$idFestival, $idSpectacle);
        $infosSpectacle = $this->grijModele->recupererProfilSpectacle($pdo, $idFestival, $idSpectacle);
        $grij = $this->grijModele->recupererGrij($pdo, $idFestival);
        $spectacleNonPlace = $this->grijModele->recupererSpectacleNonPlace($pdo,$idFestival);

        $vue = new View("vues/vue_consultation_planification");
        $vue->setVar('idFestival', $idFestival);
        $vue->setVar('message', $message);
        $vue->setVar('profilSpectacle', true);
        $vue->setVar('listeScenes', $listeScenes);
        $vue->setVar('infosSpectacle', $infosSpectacle);
        $vue->setVar('listeJours', $grij);
        $vue->setVar('listeSpectacleNonPlace', $spectacleNonPlace);
        return $vue;
    }

    public function convertirMinutesEnHeuresMySQL($minutes) {
        $heures = floor($minutes / 60);
        $minutesRestantes = $minutes % 60;
        $tempsFormate = new DateTime("1970-01-01 $heures:$minutesRestantes:00");
        $tempsMySQL = $tempsFormate->format('H:i:s');
        
        return $tempsMySQL;
    }
}