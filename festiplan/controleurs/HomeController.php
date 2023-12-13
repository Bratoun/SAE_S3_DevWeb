<?php

namespace controleurs;

use PDO;
use yasmf\View;

class HomeController {

    public function __construct() {
    }

    public function index() {
        return new View("vues/vueConnexion");
    }
}