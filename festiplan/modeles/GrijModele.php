<?php

namespace modeles;

use PDO;
use PDOException;
use DateTime;

class GrijModele
{

    public function modifierCreerGrij(PDO $pdo, $idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles)
    {
        try {
            // Début de la transaction
            $pdo->beginTransaction();
        
            // Vérifier si l'ID du festival existe dans la table Grij
            $stmt = $pdo->prepare("SELECT 1 FROM Grij WHERE idGrij = ?");
            $stmt->execute([$idFestival]);
        
            if ($stmt->rowCount() > 0) {
                // Si l'ID existe, effectuer une mise à jour
                $stmt = $pdo->prepare("UPDATE Grij SET heureDebut = ?, heureFin = ?, tempsEntreSpectacle = ? WHERE idGrij = ?");
                $stmt->execute([$heureDebut, $heureFin, $ecartEntreSpectacles, $idFestival]);
        
                // Suppression des jours déjà générés
                $stmt = $pdo->prepare("DELETE FROM Jour WHERE idGrij = ?");
                $stmt->execute([$idFestival]);
            } else {
                // Si l'ID n'existe pas, effectuer une insertion
                $stmt = $pdo->prepare("INSERT INTO Grij (idGrij, heureDebut, heureFin, tempsEntreSpectacle) VALUES (?,?,?,?)");
                $stmt->execute([$idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles]);
            }
        
            // Récupérer les dates du Festival
            $stmt = $pdo->prepare("SELECT dateDebut, dateFin FROM Festival WHERE idFestival = ?");
            $stmt->execute([$idFestiVal]);
            $row = $stmt->fetch();
            $f_dateDebut = $row['dateDebut'];
            $f_dateFin = $row['dateFin'];
        
            // Insérer les jours dans la table Jour

            $sql = "INSERT INTO Jour (idGrij, dateDuJour) VALUES";
            while (strtotime($f_dateDebut) <= strtotime($f_dateFin)) {
                $stmt->execute();
                $f_dateDebut = date("Y-m-d", strtotime($f_dateDebut . " +1 day"));
            }
        
            // Valider la transaction
            $pdo->commit();
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function recupererParametresGrij(PDO $pdo, $idFestival)
    {
        $sql = "SELECT heureDebut, heureFIn, tempsEntreSpectacle FROM Grij WHERE idGrij = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }

    public function recupererJours(PDO $pdo, $idFestival)
    {
        $sql = "SELECT * FROM Jour WHERE idGrij = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }
}