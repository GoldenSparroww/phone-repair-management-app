<?php
namespace App\Core;

use ReflectionClass;
use Exception;

/**
 * Třída DIContainer zajišťuje správu závislostí a jejich automatické vkládání (Dependency Injection).
 * Podporuje manuální registraci továren i automatické řešení závislostí pomocí reflexe (Autowiring).
 */
class DIContainer
{
    private array $entries = [];
    private array $instances = []; // Cache pro Singletony (zatím se nepoužívá)

    /**
     * Ručně zaregistruje tovární funkci pro konkrétní identifikátor.
     * * @param string $id Plně kvalifikovaný název třídy nebo identifikátor služby.
     * @param callable $factory Funkce, která přijímá instanci kontejneru a vrací vytvořený objekt.
     * @return void
     */
    public function set(string $id, callable $factory): void
    {
        $this->entries[$id] = $factory;
    }

    /**
     * Získá instanci požadované třídy nebo služby.
     * * Postupně se pokouší o:
     * 1. Vrácení již existující instance z mezipaměti.
     * 2. Spuštění zaregistrované tovární funkce.
     * 3. Automatické vytvoření instance pomocí reflexe (Autowiring).
     * * @param string $id Plně kvalifikovaný název třídy nebo identifikátor služby.
     * @return mixed Výsledná instance požadované třídy.
     * @throws Exception Pokud třídu nelze instancovat nebo nelze vyřešit její závislosti.
     */
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

    /**
     * Vytvoří instanci třídy analýzou parametrů jejího konstruktoru.
     * * Metoda rekurzivně volá metodu get() pro každý parametr konstruktoru,
     * který je definován typem třídy.
     * * @param string $id Plně kvalifikovaný název třídy.
     * @return object Nová instance požadované třídy.
     * @throws Exception Pokud třída neexistuje, není instancovatelná nebo má v konstruktoru vestavěný typ (string, int atd.).
     */
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

    /**
     * Ověří, zda je kontejner schopen poskytnout instanci daného identifikátoru.
     * * @param string $id Plně kvalifikovaný název třídy nebo identifikátor služby.
     * @return bool Vrací true, pokud existuje tovární funkce nebo třída v systému.
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]) || class_exists($id);
    }
}