<?php

namespace controleurs;

use PDO;
use yasmf\View;

class HomeController {

    public function __construct() {
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        session_start();
        if (isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
            return new View("vues/vue_accueil");
        } else {
            return new View("vues/vue_connexion");
        }
    }
}