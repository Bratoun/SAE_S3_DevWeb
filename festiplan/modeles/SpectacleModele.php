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
     * @return searchStmt
     */
    public function insertionspectacle(PDO $pdo)
    {
        $sql = "INSERT INTO Spectacle (idSpectacle,titre,description,duree,illustration,categorie,tailleSceneRequise) VALUES ('1',)"
    }

}