<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;
use yasmf\HttpHelper;

class CreationCompteControleur
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele) {
        $this->userModele = $userModele;
    }
    
    public function index(PDO $pdo)
    {
        // $login = HttpHelper::getParam();
        // $mdp = HttpHelper::getParam();
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $email = HttpHelper::getParam('email');        
        try {
            // $searchStmt = creerCompteUtilisateur($pdo, $login, $mdp, $nom, $prenom, $email);
            return new View("vues/vue_connexion");
        } catch (PDOException $e) {
            return new View("vues/vue_inscription");
        }
    }
}