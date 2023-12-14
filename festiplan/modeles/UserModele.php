<?php

namespace modeles;

use PDOException;

class ConnexionModele
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
    public function trouverCompteUtilisateurParLoginMdp(PDO $pdo, $login, $pwd)
    {
        $sql = "SELECT * FROM Utilisateur WHERE login = ? AND mdp = ?";
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
        $sql = "START TRANSACTION;
        INSERT INTO Utilisateur (login, mdp, nom, prenom, mail)
        SELECT :login, :mdp, :nom, :prenom, :email
        WHERE NOT EXISTS (SELECT 1 FROM Utilisateur WHERE login = :login OR mail = :email);
        COMMIT;";
        $serachStmt = $pdo->prepare($sql);
        $searchStmt->execute(["login"=>$login, "mdp"=>$mdp, "nom"=>$nom,"prenom"=>$prenom,"email"=>$email]);
    }
}