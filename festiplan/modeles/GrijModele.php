<?php

namespace modeles;

use PDO;
use PDOException;

class GrijModele
{

    public function modifierCreerGrij(PDO $pdo, $idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles)
    {
        $sql = "SELECT InsertOuUpdateGrij(?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles]);
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