<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;

class ConnexionControleur
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele){
        $this->userModele = $userModele;
    }

    public function index($pdo)
    {
        // $searchStmt = $this->userModele->findUserByLoginAndPWD($pdo)
    }
}