<?php

namespace controleurs;

use PDO;
use yasmf\View;

class CreerFestivalControleur {

    public function __construct() {
    }

    public function index() {
        return new View("vues/vue_creer_festival");
    }
}