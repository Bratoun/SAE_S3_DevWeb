<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\HttpHelper;
use yasmf\View;

class ConnexionControleurs
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele){
        $this->userModele = $userModele;
    }

    public function index($pdo)
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
}