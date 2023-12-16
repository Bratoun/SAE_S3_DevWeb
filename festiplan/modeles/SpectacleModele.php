<?php

namespace modeles;

use PDOException;
use PDO;

class SpectacleModele 
{
    /**
     * Renvoie dans une liste déroulante les différentes 
     * catégories de spectacles
     * @param pdo un objet PDO connecté à la base de données.
     * @return searchStmt
     */
    public function listeCategorieSpectacle(PDO $pdo)
    {
        $sql = "SELECT * FROM CategorieSpectacle";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * Renvoie dans une liste déroulante les différentes 
     * tailles de scènes
     * @param pdo un objet PDO connecté à la base de données.
     * @return searchStmt
     */
    public function listeTailleScene(PDO $pdo)
    {
        $sql = "SELECT * FROM Taille";
        $search_stmt = $pdo->prepare($sql);
        $search_stmt->execute();
        return $search_stmt;
    }

    /**
     * Insèrer un spectacle dans la base de données
     * @param pdo un objet PDO connecté à la base de données.
     * @param nom nom du spectalce
     * @param description description du spectacle
     * @param duree temps du spectacle
     * @param illustration image du spectacle
     * @param categorie du spectacle
     * @param taille de la scène dont le spectacle à besoin
     * @return searchStmt
     */
    public function insertionspectacle(PDO $pdo, $nom, $description, $duree, $illustration, $categorie, $taille)
    {
        $sql = "INSERT INTO Spectacle (titre,description,duree,illustration,categorie,tailleSceneRequise) VALUES (:leTitre,:laDesc,:leTemps,:illu,:laCate,:tailleScene)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("leTitre",$titre);
        $stmt->bindParam("laDesc",$description);
        $stmt->bindParam("leTemps",$duree);
        $stmt->bindParam("illu",$illustration);
        $stmt->bindParam("laCate",$categorie);
        $stmt->bindParam("tailleScene",$taille);
        $stmt->execute();
    }
}