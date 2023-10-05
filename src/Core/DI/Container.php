<?php

namespace App\Core\Di;

class Container
{
    protected $services = [];

    public function set($name, $service)
    {
        $this->services[$name] = $service;
    }

    public function get($name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service {$name} not found");
        }
        // Если это замыкание, вызываем его, чтобы получить экземпляр сервиса
        if (is_callable($this->services[$name])) {
            return $this->services[$name]($this);
        }
        // Иначе просто возвращаем сервис
        return $this->services[$name];
    }
}