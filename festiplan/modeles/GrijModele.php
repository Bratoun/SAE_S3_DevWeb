<?php

namespace modeles;

use PDO;
use PDOException;

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
                $stmt = $pdo->prepare("DELETE FROM SpectaclesJour WHERE idFestival = ?");
                $stmt->execute([$idFestival]);
                $stmt = $pdo->prepare("DELETE FROM Jour WHERE idGrij = ?");
                $stmt->execute([$idFestival]);
            } else {
                // Si l'ID n'existe pas, effectuer une insertion
                $stmt = $pdo->prepare("INSERT INTO Grij (idGrij, heureDebut, heureFin, tempsEntreSpectacle) VALUES (?,?,?,?)");
                $stmt->execute([$idFestival, $heureDebut, $heureFin, $ecartEntreSpectacles]);
            }
        
            // Récupérer les dates du Festival
            $stmt = $pdo->prepare("SELECT dateDebut, dateFin FROM Festival WHERE idFestival = ?");
            $stmt->execute([$idFestival]);
            $row = $stmt->fetch();
            $f_dateDebut = $row['dateDebut'];
            $f_dateFin = $row['dateFin'];
            
            // Insérer les jours dans la table Jour
            $listeDate = array();
            $sql = "INSERT INTO Jour (idGrij, dateDuJour) VALUES";
            while (strtotime($f_dateDebut) <= strtotime($f_dateFin)) {
                $sql .= " ( ? , ? ),";
                $listeDate[] = intval($idFestival);
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

    public function recupererSpectacles(PDO $pdo, $idFestival)
    {
        $sql = "SELECT spec.titre as titre, spec.duree as duree, spec.tailleSceneRequise as taille, spec.idSpectacle as id
        FROM Festival as f
        JOIN SpectacleDeFestival as sf ON f.idFestival = sf.idFestival
        JOIN Spectacle as spec ON spec.idSpectacle = sf.idSpectacle
        WHERE f.idFestival = ?
        ORDER BY spec.duree";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }

    public function recupererScenes(PDO $pdo, $idFestival)
    {
        $sql = "SELECT sc.taille as taille, sc.nom as nom
        FROM Festival as f
        JOIN SceneFestival as scf ON f.idFestival = scf.idFestival
        JOIN Scene as sc ON sc.idScene = scf.idScene
        WHERE f.idFestival = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }

    public function insertSpectaclesParJour(PDO $pdo,$idFestival, $idJour, $idSpectacle, $ordre, $place, $heureDebut, $heureFin, $causeNonPlace)
    {
        $sql = "INSERT INTO SpectaclesJour VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival,$idJour, $idSpectacle, $ordre, $place,$heureDebut,$heureFin, $causeNonPlace]);
    }

    public function recupererGrij(PDO $pdo, $idFestival)
    {
        $sql = "SELECT j.dateDuJour as dateJour, GROUP_CONCAT(DISTINCT s.titre ORDER BY sj.ordre) as titres, GROUP_CONCAT(DISTINCT sj.idSpectacle ORDER BY sj.ordre) as idSpectacles,
                GROUP_CONCAT(DISTINCT sj.heureDebut) as heureDebut, GROUP_CONCAT(DISTINCT sj.heureFin) as heureFin
                FROM Grij as g
                JOIN Jour as j ON j.idGrij = g.idGrij
                JOIN SpectaclesJour as sj ON j.idJour = sj.idJour
                JOIN Spectacle as s ON s.idSpectacle = sj.idSpectacle
                WHERE sj.place = 1
                AND g.idGrij = ?
                GROUP BY j.idJour, j.dateDuJour
                ORDER BY j.dateDuJour";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }
    
    public function recuperationSceneAdequate(PDO $pdo, $idFestival, $taille)
    {
        $sql = "SELECT s.idScene FROM Festival as f
                JOIN SceneFestival as sf
                ON f.idFestival = sf.idFestival
                JOIN Scene as s
                ON s.idScene = sf.idScene
                WHERE f.idFestival = ?
                AND s.taille >= ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival, $taille]);
        return $stmt;
    }

    public function insertionSpectacleScene(PDO $pdo, $idFestival, $idSpectacle, $listeScenesAdequates)
    {
        // Suppression de la liste des scènes existante du spectacle
        $sql = "DELETE FROM SpectacleScenes WHERE idSpectacle = ".$idSpectacle;
        $stmt = $pdo->query($sql);

        // Ajout de la liste des scènes possibles du spectacle
        $sql = "INSERT INTO SpectacleScenes (idSpectacle,idScene,idFestival)
                VALUES ";
        foreach($listeScenesAdequates as $idScene) {
            $sql .= "(".$idSpectacle.",".$idScene['idScene'].",".$idFestival."),";
        }
        $sql = substr($sql,0,-1);
        $stmt = $pdo->query($sql);
        return $stmt;
    }

    public function recupererListeScenes(PDO $pdo, $idFestival, $idSpectacle)
    {
        $sql = "SELECT s.nom as nomScene, s.nombreSpectateurs as nbSpectateurs, s.longitude as longitude,
                s.latitude as latitude
                FROM SpectaclesJour as sj
                JOIN SpectacleScenes as ss
                ON sj.idFestival = ss.idFestival AND sj.idSpectacle = ss.idSpectacle
                JOIN Scene as s
                ON s.idScene = ss.idScene
                WHERE sj.idFestival = ?
                AND sj.idSpectacle = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival, $idSpectacle]);
        return $stmt;
    }

    public function recupererProfilSpectacle(PDO $pdo, $idFestival, $idSpectacle)
    {
        $sql = "SELECT sj.heureDebut as heureDebut, sj.heureFin as heureFin, s.titre as titre, s.duree as duree
                FROM SpectaclesJour as sj
                JOIN Spectacle as s
                ON s.idSpectacle = sj.idSpectacle
                WHERE sj.idFestival = ?
                AND sj.idSpectacle = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival, $idSpectacle]);
        return $stmt;
    }
    public function recupererSpectacleNonPlace(PDO $pdo, $idFestival)
    {
        $sql = "SELECT s.titre as titre, s.duree as duree
                FROM SpectaclesJour as sj
                JOIN Spectacle as s
                ON s.idSpectacle = sj.idSpectacle
                WHERE sj.idFestival = ?
                AND sj.place = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFestival]);
        return $stmt;
    }
}