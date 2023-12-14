<?php

namespace controleurs;

use PDO;
use yasmf\View;

class InscriptionControleur
{

    public function __construct() {

    }

    public function index() {
        return new View("vues/vue_inscription");
    }
}