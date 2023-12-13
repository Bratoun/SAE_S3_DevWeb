<?php

namespace application;

use controleurs\HomeController;
use yasmf\ComponentFactory;
use yasmf\NoControllerAvailableForNameException;
use yasmf\NoServiceAvailableForNameException;

class DefaultComponentFactory implements ComponentFactory
{
    public function buildControllerByName(string $controller_name): mixed {
        return match ($controller_name) {
            "Home" => $this->buildHomeController(),
            default => throw new NoControllerAvailableForNameException($controller_name)
        };
    }

    private function buildUsersService(): UsersService
    {
        if ($this->usersService == null) {
            $this->usersService = new UsersService();
        }
        return $this->usersService;
    }

    public function buildServiceByName(string $service_name): mixed
    {
        throw new NoServiceAvailableForNameException($service_name);
    }

    private function buildHomeController(): HomeController
    {
        return new HomeController($this->buildUsersService());
    }
}