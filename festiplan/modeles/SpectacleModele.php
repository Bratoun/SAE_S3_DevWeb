<?php

namespace modeles;

use PDOException;
use PDO;

class SpectacleModele 
{
    /**
     * Renvoie dans une liste déroulante les différentes 
     * catégories de spectacles
     */
    public function listeCategorieSpectacle(PDO $pdo)
    {
        $sql = "SELECT * FROM CategorieSpectacle";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }
}