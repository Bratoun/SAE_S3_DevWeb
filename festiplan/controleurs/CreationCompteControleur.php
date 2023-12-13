<?php

namespace controleurs;

use modeles\UserModele;
use yasmf\View;

class CreationCompteControleur
{

    public function __construct() {

    }
    
    public function index($pdo)
    {
        return new View("vues/vueInscription");
    }
}