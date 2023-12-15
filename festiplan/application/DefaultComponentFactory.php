<?php

namespace application;

use controleurs\HomeController;
use controleurs\CreerFestivalControleur;
use controleurs\CreerSpectacleControleur;
use controleurs\AccueilControleur;
use controleurs\InscriptionControleur;
use controleurs\ConnexionControleur;
use controleurs\UtilisateurCompteControleur;
use modeles\UserModele;
use modeles\SpectacleModele;
use modeles\FestivalModele;
use yasmf\ComponentFactory;
use yasmf\NoControllerAvailableForNameException;
use yasmf\NoServiceAvailableForNameException;

class DefaultComponentFactory implements ComponentFactory 
{

    private ?UserModele $userModele = null;

    private ?SpectacleModele $spectacleModele = null;

    private ?FestivalModele $festivalModele = null;

    public function buildControllerByName(string $controller_name): mixed {
        return match ($controller_name) {
            "Home" => $this->buildHomeController(),
            "Accueil" => $this->buildAccueilController(),
            "CreerSpectacle" => $this->buildCreerSpectacleController(),
            "CreerFestival" => $this->buildCreerFestivalController(),
            // "Inscription" => $this->buildInscriptionController(),
            // "CreationCompte" => $this->buildCreationCompteController(),
            // "Connexion" => $this->buildConnexionController(),
            "UtilisateurCompte" => $this->buildUtilisateurCompteController(),
            default => throw new NoControllerAvailableForNameException($controller_name)
        };
    }

    public function buildServiceByName(string $service_name): mixed
    {
        return match ($service_name){
            "User" => $this->buildUserModele(),
            "CreerSpectacle" => $this->buildSpectacleModele(),
            "CreerFestival" => $this->buildFestivalModele(),
            default => throw new NoServiceAvailableForNameException($service_name)
        };
    }

    private function buildHomeController(): HomeController
    {
        return new HomeController();
    }

    private function buildAccueilController(): AccueilControleur
    {
        return new AccueilControleur();
    }
    
    private function buildCreerSpectacleController(): CreerSpectacleControleur
    {
        return new CreerSpectacleControleur($this->buildServiceByName("CreerSpectacle"));
    }
    
    private function buildCreerFestivalController(): CreerFestivalControleur
    {
        return new CreerFestivalControleur($this->buildServiceByName("CreerFestival"));
    }

    private function buildInscriptionController(): InscriptionControleur
    {
        return new InscriptionControleur();
    }

    private function buildCreationCompteController() : CreationCompteControleur
    {
        return new CreationCompteControleur($this->buildServiceByName("User"));
    }

    private function buildConnexionController() : ConnexionControleur
    {
        return new ConnexionControleur($this->buildServiceByName("User"));
    }

    private function buildUtilisateurCompteController() : UtilisateurCompteControleur
    {
        return new UtilisateurCompteControleur($this->buildServiceByName("User"));
    }
    
    private function buildUserModele() : UserModele
    {
        if ($this->userModele == null) {
            $this->userModele = new UserModele();
        }
        return $this->userModele;
    }

    private function buildSpectacleModele() : SpectacleModele
    {
        if ($this->spectacleModele == null) {
            $this->spectacleModele = new SpectacleModele();
        }
        return $this->spectacleModele;
    }

    private function buildFestivalModele() : FestivalModele
    {
        if ($this->festivalModele == null) {
            $this->festivalModele = new FestivalModele();
        }
        return $this->festivalModele;
    }
}