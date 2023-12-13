<?php

namespace application;

use controleurs\HomeController;
use controleurs\CreerFestivalControleur;
use controleurs\CreerSpectacleControleur;
use controleurs\AccueilControleur;
use yasmf\ComponentFactory;
use yasmf\NoControllerAvailableForNameException;
use yasmf\NoServiceAvailableForNameException;

class DefaultComponentFactory implements ComponentFactory
{
    public function buildControllerByName(string $controller_name): mixed {
        return match ($controller_name) {
            "Home" => $this->buildHomeController(),
            "Accueil" => $this->buildAccueilController(),
            "CreerSpectacle" => $this->buildCreerSpectacleController(),
            "CreerFestival" => $this->buildCreerFestivalController(),
            default => throw new NoControllerAvailableForNameException($controller_name)
        };
    }

    public function buildServiceByName(string $service_name): mixed
    {
        throw new NoServiceAvailableForNameException($service_name);
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
        return new CreerSpectacleControleur();
    }
    
    private function buildCreerFestivalController(): CreerFestivalControleur
    {
        return new CreerFestivalControleur();
    }
}