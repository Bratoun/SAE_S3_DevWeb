<?php

namespace modeles;

use PDOException;
use PDO;

class FestivalModele
{
    /**
     * Recherche la liste des categories de festival dans la base de données 
     * @param pdo un objet PDO connecté à la base de données.
     * @return searchStmt l'ensemble des categorie de festival
     */
    public function listeCategorieFestival(PDO $pdo)
    {
        $sql = "SELECT * FROM CategorieFestival ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * Insere un festival dans la base de données
     * @param pdo un objet PDO connecté à la base de données.
     * @param nom nom du festival.
     * @param description description du festival.
     * @param dateDebut date de debut du festival.
     * @param dateFin date de fin du festival.
     * @param categorie categorie du festival.
     * @param illustration illustration du festival.
     * @return stmt true si cela a marché
     */
    public function insertionFestival(PDO $pdo, $nom, $description, $dateDebut, $dateFin, $categorie, $illustration)
    {
        $sql = "INSERT INTO Festival (nom,categorie,description,dateDebut,dateFin,illustration) VALUES (:leNom,:laCate,:laDesc,:leDeb,:laFin,:lIllu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("leNom",$nom);
        $stmt->bindParam("laCate",$categorie);
        $stmt->bindParam("laDesc",$description);
        $stmt->bindParam("leDeb",$dateDebut);
        $stmt->bindParam("laFin",$dateFin);
        $stmt->bindParam("lIllu",$illustration);
        $stmt->execute();
        // Enregistre le créateur du festival en temps qu'organisateur
        $idFestival = $pdo->lastInsertId();
        $idOrganisateur = ;
        $sql2 = "INSERT INTO EquipeOrganisatrice (idUtilisateur, idFestival) VALUES (:idOrg,:idFestival)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam("idOrg",$idOrganisateur);
        $stmt2->bindParam("idFestival",$idFestival);
        $stmt2->execute();
    }

}