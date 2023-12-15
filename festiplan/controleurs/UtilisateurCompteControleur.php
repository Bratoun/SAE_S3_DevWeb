<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\HttpHelper;
use yasmf\View;

class UtilisateurCompteControleur
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele){
        $this->userModele = $userModele;
    }

    public function connexion($pdo)
    {
        $login = HttpHelper::getParam('login');
        $mdp = HttpHelper::getParam('mdp');
        $searchStmt = $this->userModele->trouverCompteUtilisateurParLoginMdp($pdo, $login, $mdp);
        $user = $searchStmt->fetch();
        if (!$user){
            return new View("vues/vue_connexion");
        } else {
            return new View("vues/vue_accueil");
        }
    }
    public function creerCompteUtilisateur(PDO $pdo)
    {
        if (true){ // faire un hidden avec une variable qui est true dans le form TRUST
            // $login = HttpHelper::getParam('login');
            // $mdp = HttpHelper::getParam('mdp');
            $nom = HttpHelper::getParam('nom');
            $prenom = HttpHelper::getParam('prenom');
            $email = HttpHelper::getParam('email');
            try {
                // $searchStmt = creerCompteUtilisateur($pdo, $login, $mdp, $nom, $prenom, $email);
                return new View("vues/vue_connexion");
            } catch (PDOException $e) {
                return new View("vues/vue_inscription");
            }
        } else {
            return new View("vues/vue_inscription");
        }
    }
}