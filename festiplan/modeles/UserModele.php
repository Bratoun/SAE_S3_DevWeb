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
    public function findUserByLoginAndPWD(PDO $pdo, $login, $pwd)
    {
        $sql = "SELECT * FROM Utilisateur WHERE pseudo = :login AND mdp = :pwd";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute([$codeCategorie]);
        return $searchStmt;
    }
}