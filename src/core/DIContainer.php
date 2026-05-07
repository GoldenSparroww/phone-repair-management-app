<?php
namespace App\Core;

use ReflectionClass;
use Exception;

class DIContainer
{
    private array $entries = [];
    private array $instances = []; // Cache pro Singletony

    public function set(string $id, callable $factory): void
    {
        $this->entries[$id] = $factory;
    }

    public function get(string $id)
    {
        // 1. Pokud už máme hotovou instanci (Singleton), vrátíme ji
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        // 2. Pokud máme ruční definici (factory), použijeme ji
        if (isset($this->entries[$id])) {
            return $this->instances[$id] = ($this->entries[$id])($this);
        }

        // 3. Jinak zkusíme Autowiring
        return $this->instances[$id] = $this->autowire($id);
    }

    private function autowire(string $id)
    {
        $reflection = new ReflectionClass($id);

        if (!$reflection->isInstantiable()) {
            throw new Exception("Třída $id není instancovatelná.");
        }

        $constructor = $reflection->getConstructor();

        // Pokud nemá konstruktor, prostě vytvoříme novou instanci
        if (is_null($constructor)) {
            return new $id();
        }

        // Pokud konstruktor má, projdeme jeho parametry
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if (!$type || $type->isBuiltin()) {
                throw new Exception("Nelze automaticky vyřešit parametr '{$parameter->getName()}' u třídy $id.");
            }

            // Rekurzivně získáme závislost z kontejneru
            $dependencies[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]) || class_exists($id);
    }
}