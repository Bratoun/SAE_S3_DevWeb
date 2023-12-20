<?php

namespace modeles;

use PDO;
use PDOException;
use DateTime;

class GrijModele
{
//     DELIMITER //

// CREATE PROCEDURE InsertOuUpdateGrij(idFesti INT(11), heureDebutSpec TIME, heureFinSpec TIME, ecart TIME)
// BEGIN
//     DECLARE f_dateDebut DATE;
//     DECLARE f_dateFin DATE;

//     START TRANSACTION;

//     -- Vérifier si l'ID du festival existe dans la table Grij
//     IF EXISTS (SELECT 1 FROM Grij WHERE idGrij = idFesti) THEN
//         -- Si l'ID existe, effectuer une mise à jour
//         UPDATE Grij
//         SET heureDebut = heureDebutSpec, heureFin = heureFinSpec, tempsEntreSpectacle = ecart
//         WHERE idGrij = idFesti;

//         -- suppression des jours déjà générés
//         DELETE FROM Jour WHERE idGrij = idFesti;
//     ELSE
//         -- Si l'ID n'existe pas, effectuer une insertion
//         INSERT INTO Grij (idGrij, heureDebut, heureFin, tempsEntreSpectacle)
//         VALUES (idFesti, heureDebutSpec, heureFinSpec, ecart);
//     END IF;

//     -- Récupérer les dates du Festival
//     SELECT dateDebut, dateFin INTO f_dateDebut, f_dateFin FROM Festival WHERE idFestival = idFesti;

//     -- Insérer les jours dans la table Jour
//     WHILE f_dateDebut <= f_dateFin DO
//         INSERT INTO Jour (idGrij, dateDuJour) VALUES (idFesti, f_dateDebut);
//         SET f_dateDebut = DATE_ADD(f_dateDebut, INTERVAL 1 DAY);
//     END WHILE;

//     COMMIT;
// END //

// DELIMITER ;
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
            $stmt->execute([$idFestivl]);
            $row = $stmt->fetch();
            $f_dateDebut = $row['dateDebut'];
            $f_dateFin = $row['dateFin'];
        
            // Insérer les jours dans la table Jour
            $listeDate = array('idG' => $idFestival);
            $sql = "INSERT INTO Jour (idGrij, dateDuJour) VALUES";
            while (strtotime($f_dateDebut) <= strtotime($f_dateFin)) {
                $sql .= " (?,?),";
                $listeDate[] = $idFestival;
                $listeDate[] = $f_dateDebut;
                $f_dateDebut = date("Y-m-d", strtotime($f_dateDebut . " +1 day"));
            }
            // On retire la virgule finale
            $sql = rtrim($sql, ',');
            $stmt = $pdo->prepare($sql);
            $stmt->execute($listeDate);

            // Valider la transaction
            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public function recupererParametresGrij(PDO $pdo, $idFestival)
    {
        $sql = "SELECT heureDebut, heureFin, tempsEntreSpectacle FROM Grij WHERE idGrij = ?";
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