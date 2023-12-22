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
            
            $ok = $this->grijModele->modifierCreerGrij($pdo, $idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles);
            if ($ok){
                $stmt = $this->grijModele->recupererJours($pdo, $idFestival);
                $vue = new View('vues/vue_consultation_planification');
                $vue->setVar('listeJours', $stmt);
            } else {
                $vue = new View('vues/vue_parametres_grij');
                $message = "Erreur avec la base de données.";
                $vue->setVar('heureDebut', $heureDebut);
                $vue->setVar('heureFin', $heureFin);
                $vue->setVar('ecartEntreSpectacles', $ecartEntreSpectacles);
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

        while (($jour =$jours->fetch()) && $unSpectacle) {
            $ordre = 0;
            $duree = 0;
            
            if (($this->convertirEnMinutes($unSpectacle['duree'])+ $duree) < $dureeTotal) {
                $duree += $this->convertirEnMinutes($unSpectacle['duree']);
                $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, $jour['idJour'],$unSpectacle['id'], null, $ordre, 1);
                $ordre++;
                $duree += $ecart;
            }

            while($duree < $dureeTotal && ($unSpectacle = $spectacles->fetch())) {
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
                $unSpectacle = false;
            }
        }
        if ($unSpectacle != false) {
            $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], null, 0, 0);
            while ($unSpectacle = $spectacles->fetch()){
                $this->grijModele->insertSpectaclesParJour($pdo,$idFestival, null,$unSpectacle['id'], null, 0, 0);
            }
        }
    }
}