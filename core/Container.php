<?php
namespace Core;

use Exception;
use ReflectionClass;

class Container {
    private array $bindings = [];

    public function bind(string $abstract, callable|string $concrete): void {
        $this->bindings[$abstract] = $concrete;
    }

    public function make(string $abstract): mixed {
        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            if (is_callable($concrete)) {
                return $concrete($this);
            }
            $abstract = $concrete;
        }

        $reflector = new ReflectionClass($abstract);
        if (!$reflector->isInstantiable()) {
            throw new Exception("[%s] n'est pas instanciable.", $abstract);
        }

        $constructor = $reflector->getConstructor();
        if ($constructor === null) {
            return new $abstract();
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->make($type->getName());
            } else if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new Exception("Impossible de résoudre la dépendance \${$parameter->name} pour {$abstract}");
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}