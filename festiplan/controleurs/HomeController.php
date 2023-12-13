<?php

namespace controleurs;

use PDO;
use yamsf\View;

class HomeController {

    public function __construct() {
        
    }

    public function index() {
        return new View("vues/vueConnexion");
    }
}