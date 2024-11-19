<?php

namespace Src\Core;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container
{
    private array $bindings = [];

    /**
     * Bind a key to a resolver.
     *
     * @param string $key
     * @param callable $resolver
     */
    public function bind(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * Resolve an instance of the given key.
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function resolve(string $key): mixed
    {
        if (array_key_exists($key, $this->bindings)) {
            return call_user_func($this->bindings[$key]);
        }

        return $this->resolveClass($key);
    }

    /**
     * Resolve a class instance.
     *
     * @param string $class
     * @return mixed
     * @throws \Exception
     */
    private function resolveClass(string $class): mixed
    {
        try {
            $reflectionClass = new ReflectionClass($class);

            if (!$reflectionClass->isInstantiable()) {
                throw new \Exception("Class {$class} is not instantiable.");
            }

            $constructor = $reflectionClass->getConstructor();

            if (is_null($constructor)) {
                return $reflectionClass->newInstance();
            }

            $dependencies = $this->resolveDependencies($constructor->getParameters());
            return $reflectionClass->newInstanceArgs($dependencies);

        } catch (ReflectionException $e) {
            throw new \Exception("Class {$class} not found.", 0, $e);
        }
    }

    /**
     * Resolve an array of dependencies.
     *
     * @param ReflectionParameter[] $parameters
     * @return array
     * @throws \Exception
     */
    private function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencies[] = $this->resolveParameter($parameter);
        }

        return $dependencies;
    }

    /**
     * Resolve a single parameter.
     *
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws \Exception
     */
    private function resolveParameter(ReflectionParameter $parameter): mixed
    {
        $type = $parameter->getType();

        if (is_null($type) || $type->isBuiltin()) {
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }

            throw new \Exception("Cannot resolve parameter {$parameter->getName()}.");
        }

        return $this->resolve($type->getName());
    }
}
