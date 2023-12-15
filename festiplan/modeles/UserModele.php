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
            var_dump($login);
            var_dump($mdp);
            var_dump($nom);
            var_dump($prenom);
            var_dump($email);
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
}