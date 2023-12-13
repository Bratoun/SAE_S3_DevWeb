<?php

namespace controleurs;

use PDO;
use yasmf\View;

class AccueilControleur {

    public function __construct() {
    }

    public function index() {
        return new View("vues/vue_accueil");
    }
}