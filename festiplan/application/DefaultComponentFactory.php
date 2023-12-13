<?php

namespace application;

use controleurs\HomeController;
use controleurs\AccueilControleur;
use controleurs\InscriptionControleur;
use yasmf\ComponentFactory;
use yasmf\NoControllerAvailableForNameException;
use yasmf\NoServiceAvailableForNameException;

class DefaultComponentFactory implements ComponentFactory
{
    public function buildControllerByName(string $controller_name): mixed {
        return match ($controller_name) {
            "Home" => $this->buildHomeController(),
            "Accueil" => $this->buildAccueilController(),
            "Inscription" => $this->buildInscriptionController(),
            "CreationCompte" => $this->buildCreationCompteController(),
            default => throw new NoControllerAvailableForNameException($controller_name)
        };
    }

    public function buildServiceByName(string $service_name): mixed
    {
        return match ($service_name){
            "User" => $this->buildUserModele(),
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

    private function buildInscriptionController(): InscriptionControleur
    {
        return new InscriptionControleur();
    }

    private function buildCreationCompteController() : CreationCompteControleur
    {
        return new CreationCompteControleur($this->buildServiceByName("User"));
    }

    private function buildUserModele() : UserModele
    {
        if ($this->userModele == null) {
            $this->userModele = new UserModele();
        }
        return $this->userModele;
    }
}