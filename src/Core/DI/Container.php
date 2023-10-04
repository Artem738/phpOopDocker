<?php


namespace App\Core\Di;

use App\Core\Exeptions\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $definitions = [];
    protected array $instances = [];
    protected array $configs = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException("Service not found: " . $id);
        }

        if (!isset($this->instances[$id])) {
            $this->instances[$id] = $this->createService($id);
        }

        return $this->instances[$id];
    }

    public function has($id): bool
    {
        return isset($this->definitions[$id]);
    }

    public function bind($id, array $definition)
    {
        $this->definitions[$id] = $definition;
    }

    public function config($key, $value)
    {
        $this->configs[$key] = $value;
    }

    public function getConfig($key)
    {
        if (!isset($this->configs[$key])) {
            throw new NotFoundException("Config not found: " . $key);
        }
        return $this->configs[$key];
    }

    private function createService($id)
    {
        $definition = $this->definitions[$id];
        $arguments = [];

        if (isset($definition['arguments'])) {
            foreach ($definition['arguments'] as $argument) {
                if (is_string($argument) && strpos($argument, '@') === 0) {
                    $arguments[] = $this->get(substr($argument, 1));
                } else {
                    $arguments[] = $argument;
                }
            }
        }

        $reflection = new \ReflectionClass($definition['class']);
        return $reflection->newInstanceArgs($arguments);
    }
}
