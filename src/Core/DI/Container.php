<?php

namespace App\Core\Di;

use App\Core\Exeptions\ContainerException;
use App\Core\Exeptions\NotFoundException;
use ReflectionClass;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $bindings = [];
    protected array $instances = [];

    public function bind(string $abstract, string $concrete, array $parameters = []): void
    {
        $this->bindings[$abstract] = ['concrete' => $concrete, 'parameters' => $parameters];
    }

    public function instance(string $abstract, $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function get(string $abstract)
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            throw new NotFoundException("No binding found for {$abstract}.");
        }

        $concrete = $this->bindings[$abstract]['concrete'];
        $parameters = $this->bindings[$abstract]['parameters'];

        $object = $this->instantiate($concrete, $parameters);
        $this->instances[$abstract] = $object;

        return $object;
    }

    protected function instantiate(string $concrete, array $parameters = [])
    {
        try {
            $reflector = new ReflectionClass($concrete);
            if (!$reflector->isInstantiable()) {
                throw new ContainerException("Class {$concrete} is not instantiable.");
            }

            $constructor = $reflector->getConstructor();
            if (is_null($constructor)) {
                return new $concrete;
            }

            $dependencies = [];
            foreach ($constructor->getParameters() as $parameter) {
                $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin()
                    ? new ReflectionClass($parameter->getType()->getName())
                    : null;
                if ($dependency === null) {
                    if (isset($parameters[$parameter->getName()])) {
                        $dependencies[] = $parameters[$parameter->getName()];
                    } else {
                        throw new ContainerException("Cannot resolve class dependency {$parameter->getName()} for {$concrete}.");
                    }
                } else {
                    $dependencies[] = $this->get($dependency->getName());
                }
            }

            return $reflector->newInstanceArgs($dependencies);
        } catch (\ReflectionException $e) {
            throw new ContainerException("Error occurred while creating {$concrete}.", 0, $e);
        }
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]) || isset($this->instances[$id]);
    }
}
