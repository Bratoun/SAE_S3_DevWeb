<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;

class CreationCompteControleur
{
<<<<<<< HEAD
    public function __construct() {
=======
    private UserModele $userModele;

    public function __construct(UserModele $userModele) {
        $this->userModele = $userModele;
>>>>>>> 0b1de11f5f59c08e654497175f62afea2e3db5ba
    }

    public function index($pdo)
    {
<<<<<<< HEAD
        return new View("vues/vueInscription");
=======
        // $login = HttpHelper::getParam("login");
        // $mdp = HttpHelper::getParam("mdp");
        // $searchStmt = $this->userModele->
>>>>>>> 0b1de11f5f59c08e654497175f62afea2e3db5ba
    }
}