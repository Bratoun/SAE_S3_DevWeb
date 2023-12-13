<?php

namespace controleurs;

use PDO;
use yamsf\View;

class HomeController {
    public function index() {
        return new View("vue/connexion");
    }
}