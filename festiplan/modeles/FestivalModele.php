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
     * @param idOrganisateur l'id de l'utilisateur courant.
     * @return stmt true si cela a marché
     */
    public function insertionFestival(PDO $pdo, $nom, $description, $dateDebut, $dateFin, $categorie, $illustration, $idOrganisateur)
    {
        $sql = "INSERT INTO Festival (titre,categorie,description,dateDebut,dateFin,illustration) VALUES (:leNom,:laCate,:laDesc,:leDeb,:laFin,:lIllu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("leNom",$nom);
        $stmt->bindParam("laCate",$categorie);
        $stmt->bindParam("laDesc",$description);
        $stmt->bindParam("leDeb",$dateDebut);
        $stmt->bindParam("laFin",$dateFin);
        $stmt->bindParam("lIllu",$illustration);
        $stmt->execute();
        // Enregistre le créateur du festival en temps qu'organisateur
        $responsable = true;
        $idFestival = $pdo->lastInsertId();
        $sql2 = "INSERT INTO EquipeOrganisatrice (idUtilisateur, idFestival, responsable) VALUES (:idOrg,:idFestival,:responsable)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam("idOrg",$idOrganisateur);
        $stmt2->bindParam("idFestival",$idFestival);
        $stmt2->bindParam("responsable",$responsable);
        $stmt2->execute();
    }


    /**
     * Recherche la liste des festivals de l'utilisateur
     * @param pdo un objet PDO connecté à la base de données.
     * @param idOrganisateur l'id de l'utilisateur courant.
     * @return searchStmt l'ensemble des festivals.
     */
    public function listeMesFestivals(PDO $pdo, $idOrganisateur)
    {
        $sql = "SELECT Festival.titre,Utilisateur.nom,Festival.idFestival,Festival.illustration FROM Festival JOIN EquipeOrganisatrice ON Festival.idFestival=EquipeOrganisatrice.idFestival JOIN Utilisateur ON Utilisateur.idUtilisateur=EquipeOrganisatrice.idUtilisateur WHERE EquipeOrganisatrice.idUtilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id",$idOrganisateur);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Recherche tout les parametre du festival voulu.
     * @param pdo un objet PDO connecté à la base de données.
     * @param idFestival l'id du festival a rechercher.
     * @return fetch lefestival.
     */
    public function leFestival(PDO $pdo, $idFestival)
    {
        $sql = "SELECT * FROM Festival WHERE idFestival = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id",$idFestival);
        $stmt->execute();
        $fetch = $stmt->fetch();
        return $fetch;
    }

    /**
     * Modifier un festival dans la base de données
     * @param pdo un objet PDO connecté à la base de données.
     * @param nom nom du festival.
     * @param description description du festival.
     * @param dateDebut date de debut du festival.
     * @param dateFin date de fin du festival.
     * @param categorie categorie du festival.
     * @param illustration illustration du festival.
     * @param idFestival l'id de l'utilisateur courant.
     * @return stmt true si cela a marché
     */
    public function modificationFestival(PDO $pdo, $nom, $description, $dateDebut, $dateFin, $categorie, $illustration, $idFestival)
    {   
        $sql = "UPDATE Festival SET titre =:leNom, categorie =:laCate, description =:laDesc, dateDebut =:leDeb, dateFin =:laFin, illustration=:lIllu WHERE idFestival =:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("leNom",$nom);
        $stmt->bindParam("laCate",$categorie);
        $stmt->bindParam("laDesc",$description);
        $stmt->bindParam("leDeb",$dateDebut);
        $stmt->bindParam("laFin",$dateFin);
        $stmt->bindParam("lIllu",$illustration);
        $stmt->bindParam("id",$idFestival);
        $stmt->execute();
    }

    /**
     * Supprime festival voulu
     * @param pdo un objet PDO connecté à la base de données.
     * @param idFestival l'id du festival a supprimer.
     */
    public function supprimerFestival(PDO $pdo, $idFestival)
    {   
        $sql = "DELETE FROM EquipeOrganisatrice WHERE idFestival = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id",$idFestival);
        $stmt->execute();
        $sql2 = "DELETE FROM Festival WHERE idFestival = :id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam("id",$idFestival);
        $stmt2->execute();
    }

    /**
     * Regarde si l'utilisateur et le responsable du festival voulus.
     * @param pdo un objet PDO connecté à la base de données.
     * @param idFestival l'id du festival.
     * @param idOrganisateur l'id de l'organisateur.
     */
    public function estResponsable($pdo,$idFestival,$idOrganisateur)
    {
        $sql = "SELECT responsable FROM EquipeOrganisatrice WHERE idFestival =:idFestival AND idUtilisateur =:idUtilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("idFestival",$idFestival);
        $stmt->bindParam("idUtilisateur",$idOrganisateur);
        $stmt->execute();
        $fetch = $stmt->fetch();
        return $fetch;
    }

    /**
     * Renvoie la liste des organisateur du festival voulus.
     * @param pdo un objet PDO connecté à la base de données.
     * @param idFestival l'id du festival.
     */
    public function listeOrganisateurFestival($pdo,$idFestival) {
        $sql = "SELECT Utilisateur.nom FROM Utilisateur JOIN EquipeOrganisatrice ON Utilisateur.idUtilisateur=EquipeOrganisatrice.idUtilisateur AND idFestival =:idFestival";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("idFestival",$idFestival);
        $stmt->execute();
        return $stmt;
    }
}