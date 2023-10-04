<?php

namespace App\Core\Di;

use App\Core\Exeptions\ContainerException;
use App\Core\Exeptions\NotFoundException;
use ReflectionClass;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $binds = [];
    protected array $parameters = [];

    public function bind(string $type, string $subtype, array $params = []): void
    {
        $this->binds[$type] = $subtype;
        $this->parameters[$subtype] = $params;
    }

    public function get(string $className)
    {
        try {
            $ref = new ReflectionClass($className);
            $constructor = $ref->getConstructor();

            if ($constructor === null) {
                return new $className;
            }

            $dependencies = $this->resolveDependencies($constructor->getParameters());

            return $ref->newInstanceArgs($dependencies);
        } catch (\ReflectionException) {
            throw new NotFoundException("Class {$className} not found.");
        } catch (\Throwable $e) {
            throw new ContainerException("Error occurred while resolving dependencies or instantiating {$className}.", 0, $e);
        }
    }

    public function has(string $id): bool
    {
        return isset($this->binds[$id]);
    }

    protected function resolveDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $name = $type ? $type->getName() : null;

            if (!$name) {
                throw new ContainerException("The parameter {$parameter->getName()} does not have a type.");
            }

            if (isset($this->binds[$name])) {
                $name = $this->binds[$name];
            }

            if (isset($this->parameters[$name])) {
                $dependencies[] = new $name(...$this->parameters[$name]);
            } else {
                $dependencies[] = $this->get($name);
            }
        }

        return $dependencies;
    }


}
