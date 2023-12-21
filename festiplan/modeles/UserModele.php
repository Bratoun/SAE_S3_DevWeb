<?php

namespace modeles;

use PDO;
use PDOException;

class UserModele
{
    /**
     * Cherche un compte Festiplan dans la base de données par rapport au login
     * et au mot ed passe.
     * @param pdo un objet PDO connecté à la base de données.
     * @param login le login entré par un utilisateur.
     * @param pwd le mot de passe entré par un utilisateur.
     * @return searchStmt les données trouvées par rapport au login et mot de
     * passe.
     */
    public function trouverCompteUtilisateurParLoginMdp(PDO $pdo, $login, $mdp)
    {
        $sql = "SELECT idUtilisateur FROM Utilisateur WHERE login = ? AND mdp = ?";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute([$login, $mdp]);
        return $searchStmt;
    }

    /**
    * @param pdo
    * @param login le login choisi par l'utilisateur, doit être unique dans la
    * base de données.
    * @param mdp mot de passe entré par l'utilisateur.
    * @param nom nom entré par l'utilisateur.
    * @param prenom prenom entré par l'utilisateur.
    * @param email mail entré par l'utilisateur, doit être unique dans la base
    * de données.
    * Insert un utilisateur dans la base de données afin de créer un compte.
    */
    public function creerCompteUtilisateur(PDO $pdo, $login, $mdp, $nom, $prenom, $email)
    {
        try {
            // Début de la transaction
            $pdo->beginTransaction();
            // Requête d'insertion
            $sql = "INSERT INTO Utilisateur (login, mdp, nom, prenom, mail) VALUES (?,?,?,?,?)";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->execute([$login, $mdp, $nom, $prenom, $email]);
        
            // Fin de la transaction (enregistrement des modifications)
            $pdo->commit();
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function modifierCompteUtilisateur(PDO $pdo, $login, $mdp, $nom, $prenom) {
        try {
            // Début de la transaction
            $pdo->beginTransaction();
            
            // Requête de mise à jour
            $sql = "UPDATE Utilisateur SET mdp = ?, nom = ?, prenom = ?, login = ? WHERE idUtilisateur = ? ;";
            $updateStmt = $pdo->prepare($sql);
            session_start();
            $updateStmt->execute([$mdp, $nom, $prenom, $login, $_SESSION['id_utilisateur']]);
    
            // Fin de la transaction (enregistrement des modifications)
            $pdo->commit();
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function recupererInformationsProfil(PDO $pdo, $id) {
        $sql = "SELECT login, nom, prenom, mail FROM Utilisateur WHERE idUtilisateur = ?";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute([$id]);
        return $searchStmt;
    }
    
}