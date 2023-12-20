<?php

namespace controleurs;

use modeles\UserModele;
use PDO;
use yasmf\HttpHelper;
use yasmf\View;

class UtilisateurCompteControleur
{
    private UserModele $userModele;

    public function __construct(UserModele $userModele){
        $this->userModele = $userModele;
    }

    public function connexion($pdo)
    {
        $login = HttpHelper::getParam('login');
        $mdp = HttpHelper::getParam('mdp');
        $searchStmt = $this->userModele->trouverCompteUtilisateurParLoginMdp($pdo, $login, $mdp);
        $user = $searchStmt->fetch();
        if (!$user){
            return new View("vues/vue_connexion");
        } else {
<<<<<<< Updated upstream
            return new View("vues/vue_accueil");
=======
            session_start();
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['id_utilisateur'] = $user['idUtilisateur'];
            $idUtilisateur = $_SESSION['id_utilisateur'];
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur     );
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            $vue->setVar("afficher", false);
            return $vue;
>>>>>>> Stashed changes
        }
    }
    public function creerCompteUtilisateur(PDO $pdo)
    {
        $editer = (bool)HttpHelper::getParam('edition');
        $premierePage = (bool)HttpHelper::getParam('premierePage');
        if($premierePage ==NULL) {
            $premierePage = true;
        }
        $noRefresh = (bool)HttpHelper::getParam('noRefresh');
        if ($editer){
            $login = HttpHelper::getParam('login');
            $mdp = HttpHelper::getParam('mdp');
            $nom = HttpHelper::getParam('nom');
            $prenom = HttpHelper::getParam('prenom');
            $email = HttpHelper::getParam('email');
            try {
                $searchStmt = creerCompteUtilisateur($pdo, $login, $mdp, $nom, $prenom, $email);
                return new View("vues/vue_connexion");
            } catch (PDOException $e) {
                return new View("vues/vue_inscription");
            }
        } else {
            $view = new View("vues/vue_inscription");
            if($noRefresh){
                if ($premierePage){
                    $view->setVar('premierePage', false);
                } else {
                    $view->setVar('premierePage', true);
                }
                
            } else {
                $view->setVar('premierePage', $premierePage);
            }
            // $view->setVar('noRefresh', false);
            return $view;
        }
    }
}