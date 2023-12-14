<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;

class ConnexionControleurs
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele){
        $this->userModele = $userModele;
    }

    public function index($pdo, $login, $pwd)
    {
        $searchStmt = $this->userModele->trouverCompteUtilisateurParLoginMdp($pdo);
        $user = $searchStmt->fetch();
        if (!$user){
            return new View("vues/vue_connexion");
        } else {
            return new View("vues/vue_accueil");
        }
    }
}