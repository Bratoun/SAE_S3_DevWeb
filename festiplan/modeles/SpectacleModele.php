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
    public function insertionspectacle(PDO $pdo, $titre, $description, $duree, $illustration, $categorie, $taille, $idUtilisateur)
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
        // Enregistre le créateur du spectacle en temps qu'organisateur
        $idSpectacle = $pdo->lastInsertId();
        $sql2 = "INSERT INTO SpectacleOrganisateur (idUtilisateur, idSpectacle) VALUES (:idOrg,:idSpectacle)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam("idOrg",$idUtilisateur);
        $stmt2->bindParam("idSpectacle",$idSpectacle);
        $stmt2->execute();
    }

    /**
     * Renvoie les noms des festivals crées 
     * @param pdo un objet PDO connecté à la base de données.
     * @param idSpectacle pour savoir quelle spectacle récupéré
     * @return search_stmt
     */
    public function leSpectacle(PDO $pdo, $idSpectacle)  
    {
        $sql = "SELECT * FROM Spectacle WHERE idSpectacle = :id";
        $search_stmt = $pdo->prepare($sql);
        $search_stmt->bindParam("id",$idSpectacle);
        $search_stmt->execute();
        $fetch = $search_stmt->fetch();
        return $fetch;
    }

    /**
     * Recherche la liste des spectalce de l'utilisateur
     * @param pdo un objet PDO connecté à la base de données.
     * @param idOrganisateur l'id de l'utilisateur courant.
     * @return searchStmt l'ensemble des festivals.
     */
    public function listeMesSpectacles(PDO $pdo, $idOrganisateur) 
    {
        $sql = "SELECT Spectacle.titre,Utilisateur.nom,Spectacle.idSpectacle,Spectacle.illustration FROM Spectacle JOIN SpectacleOrganisateur ON Spectacle.idSpectacle=SpectacleOrganisateur.idSpectacle JOIN Utilisateur ON Utilisateur.idUtilisateur=SpectacleOrganisateur.idUtilisateur WHERE SpectacleOrganisateur.idUtilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id",$idOrganisateur);
        $stmt->execute();
        return $stmt;
    }
}