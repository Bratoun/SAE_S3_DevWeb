<?php

namespace controleurs;

use modeles\UserModele;
use modeles\SpectacleModele;
use modeles\FestivalModele;
use PDO;
use yasmf\HttpHelper;
use yasmf\View;

class UtilisateurCompteControleur
{
    private UserModele $userModele;

    private SpectacleModele $spectacleModele;

    private FestivalModele $festivalModele;


    public function __construct(UserModele $userModele,SpectacleModele $spectacleModele, FestivalModele $festivalModele){
        $this->userModele = $userModele;
        $this->spectacleModele = $spectacleModele;
        $this->festivalModele = $festivalModele;
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
            session_start();
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['id_utilisateur'] = $user['idUtilisateur'];
            $idUtilisateur = $_SESSION['id_utilisateur'];
            $mesSpectacles = $this->spectacleModele->listeMesSpectacles($pdo,$idUtilisateur     );
            $mesFestivals = $this->festivalModele->listeMesFestivals($pdo,$idUtilisateur);
            $vue = new View("vues/vue_accueil");
            $vue->setVar("mesSpectacles", $mesSpectacles);
            $vue->setVar("mesFestivals", $mesFestivals);
            return $vue;
        }
    }
    
    public function pageInscription() {
        $verifNom = true;
        $verifPrenom = true;
        $verifEmail = true;
        $verifLogin = true;
        $verifMdp = true;
        $verifConfirmMdp = true;
        $vue = new View("vues/vue_inscription");
        $vue->setVar("nomOk", $verifNom);
        $vue->setVar("prenomOk", $verifPrenom);
        $vue->setVar("emailOk", $verifEmail);
        $vue->setVar("loginOk", $verifLogin);
        $vue->setVar("mdpOk", $verifMdp);
        $vue->setVar("confirmMdpOk", $verifConfirmMdp);
        return $vue;
    }

    public function creerCompteUtilisateur(PDO $pdo) {
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $email = HttpHelper::getParam('email');
        $login = HttpHelper::getParam('login');
        $mdp = HttpHelper::getParam('mdp');
        $confirmMdp = HttpHelper::getParam('confirmMdp');

        // Initialisez les variables à true
        $verifNom = true;
        $verifPrenom = true;
        $verifEmail = true;
        $verifLogin = true;
        $verifMdp = true;
        $verifConfirmMdp = true;

        if (strlen($nom) > 35) {
            $verifNom = false;
        }
        if (strlen($prenom) > 30) {
            $verifPrenom = false;
        }
        if (strlen($email) > 50) {
            $verifEmail = false;
        }
        if (strlen($login) > 35) {
            $verifLogin = false;
        }
        if (strlen($mdp) > 30) {
            $verifMdp = false;
        }
        if (strlen($confirmMdp) > 30) {
            $verifConfirmMdp = false;
        }
        if ($mdp != $confirmMdp) {
            $verifConfirmMdp = false;
            $verifMdp = false;
        }

        try {
            $estOk = $verifConfirmMdp && $verifEmail && $verifLogin && $verifMdp && $verifNom && $verifPrenom;
            if ($estOk) {
                $searchStmt = $this->userModele->creerCompteUtilisateur($pdo, $login, $mdp, $nom, $prenom, $email);
                return new View("vues/vue_connexion");
            } else {
                $vue = new View("vues/vue_inscription");
                $vue->setVar("nomOk", $verifNom);
                $vue->setVar("ancienNom", $nom);
                $vue->setVar("prenomOk", $verifPrenom);
                $vue->setVar("ancienPrenom", $prenom);
                $vue->setVar("emailOk", $verifEmail);
                $vue->setVar("ancienEmail", $email);
                $vue->setVar("loginOk", $verifLogin);
                $vue->setVar("ancienLogin", $login);
                $vue->setVar("mdpOk", $verifMdp);
                $vue->setVar("confirmMdpOk", $verifConfirmMdp);
                return $vue;
            }
        } catch (PDOException $e) {
            return new View("vues/vue_inscription");
        }
    }

    public function deconnexion() {
        session_start();
        session_destroy();
        return new View("vues/vue_connexion");
    }
}