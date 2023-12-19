<?php

namespace modeles;

use PDO;
use PDOException;
use DateTime;

class GrijModele
{
    public function recupererDatesParIdFestival(PDO $pdo, $idFestival)
    {
        $sql = "SELECT f.dateDebut as dateDebut, f.dateFin as dateFin, GROUP_CONCAT(g.dateDuJour) as datesAssociees, GROUP_CONCAT(j.heureDebut) as heureDebut, GROUP_CONCAT(j.heureFin) as heureFin, GROUP_CONCAT(j.tempsEntreSpectacle) as tempsEntreSpectacle
        FROM Festival as f
        LEFT JOIN Grij as g
        ON f.idFestival = g.idFestival
        LEFT JOIN Jour as j
        ON j.idJour = g.idJour
        WHERE f.idFestival = ?
        GROUP BY f.dateDebut, f.dateFin";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute([$idFestival]);
        return $searchStmt;
    }

    public function modifierOuAjouterJour(PDO $pdo,$heureDebut, $heureFin, $ecartSpectacles, $idFestival, $dateDuJour)
    {
        // Récupération de l'id du jour correspondant
        $stmt = $this->recupererIdJourParIdFestivalEtDate($pdo,$idFestival,$dateDuJour);
        $row = $stmt->fetch();
        if ($row != null)
        {
            $idJour = $row['idJour'];
            // Si tous les paramètres sont supprimés, alors on supprime le jour modifié
            if($heureDebut != null && $heureFin != null && $ecartSpectacles != null)
            {
                $this->modifierJour($pdo, $heureDebut, $heureFin, $ecartSpectacles, $idJour);
            }
        } else {
            $this->creerjourGrij($pdo,$heureDebut, $heureFin, $ecartSpectacles, $dateDuJour, $idFestival);
        }

        
    }

    private function recupererIdJourParIdFestivalEtDate(PDO $pdo, $idFestival, $dateDuJour)
    {
        $dateDuJour = $this->formatageDate($dateDuJour);
        $sql = "SELECT idJour FROM Grij WHERE idFestival = ? AND dateDuJour = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival, $dateDuJour]);
        return $stmt;
    }

    public function creerjourGrij(PDO $pdo,$heureDebut, $heureFin, $tempsEntreSpectacle, $dateDuJour, $idFestival)
    {
        
        $dateDuJour = $this->formatageDate($dateDuJour);
        $pdo->beginTransaction();

        // Insertion du jour
        $sql = "INSERT INTO Jour (heureDebut, heureFin, tempsEntreSpectacle) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$heureDebut, $heureFin, $tempsEntreSpectacle]);

        // on récupère l'id du jour inséré
        $idJour = $pdo->lastInsertId();

        // Insertion dans la table Grij du lien entre le jour créé et le festival
        $sql2 = "INSERT INTO Grij (idFestival, idJour, dateDuJour) VALUES (?,?,?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$idFestival, $idJour,$dateDuJour]);

        $pdo->commit();
    }

    public function supprimerJour(PDO $pdo, $idFestival, $dateDuJour) {
        $stmt2 = $this->recupererIdJourParIdFestivalEtDate($pdo, $idFestival,$dateDuJour);
        $row = $stmt2->fetch();
        
        $sql = "DELETE Grij, Jour
        FROM Grij
        INNER JOIN Jour ON Grij.idJour = Jour.idJour
        WHERE Grij.idJour = :jour AND Grij.idFestival = :festi";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['jour'=>$row['idJour'], 'festi' =>$idFestival]);
    }

    private function modifierJour(PDO $pdo, $heureDebut, $heureFin, $ecartSpectacles, $idJour)
    {
        // Modification du jour
        $sql2 = "UPDATE Jour SET heureDebut = ? AND heureFin = ? AND tempsEntreSpectacle = ? WHERE idJour = ?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$heureDebut, $heureFin, $ecartSpectacles, $idJour]);
    }

    public function recupererJourParDateEtFestival(PDO $pdo, $dateDuJour, $idFestival)
    {
        $dateDuJour = $this->formatageDate($dateDuJour);
        $sql = "SELECT j.heureFin, j.heureDebut, j.tempsEntreSpectacle FROM Jour as j JOIN Grij as g ON j.idJour = g.idJour WHERE g.idFestival = ? AND g.dateDuJour = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival,$dateDuJour]);
        return $stmt;
    }

    private function formatageDate($date)
    {
        $date = DateTime::createFromFormat('d/m/Y', $date);
        $date = $date->format('Y-m-d');
        return $date;
    }
}