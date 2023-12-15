<?php

namespace modeles;

use PDOException;

class FestivalModele
{
    /**
     * Recherche la liste des categories de festival dans la base de données 
     * @param pdo un objet PDO connecté à la base de données.
     * @return searchStmt les données trouvées par rapport au login et mot de
     * passe.
     */
    public function trouverCompteUtilisateurParLoginMdp(PDO $pdo)
    {
        $sql = "SELECT * FROM CategorieFestival ";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

}