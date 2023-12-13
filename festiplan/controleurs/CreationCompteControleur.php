<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;

class CreationCompteControleur
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele) {
        $this->userModele = $userModele;
    }

    public function index($pdo)
    {
        // $login = HttpHelper::getParam("login");
        // $mdp = HttpHelper::getParam("mdp");
        // $searchStmt = $this->userModele->
    }
}