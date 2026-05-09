<?php
namespace App\Core;

use Exception;

class Router
{
    // závislost na kontejneru
    public function __construct(
        private DIContainer $diContainer
    ) {}

    public function run(): void
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $segments = explode('/', $uri);

        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DashboardController';
        $actionName = $segments[1] ?? 'index';

        // Získáme plné jméno třídy (např. App\Controllers\RepairController)
        $controllerClass = "App\\Controllers\\" . $controllerName;

        // Kontrola, zda kontejner ví, jak tento controller postavit
        if (!$this->diContainer->has($controllerClass)) {
            throw new Exception("Page '$controllerName' not found or not registered in container", 404);
        }

        // Vyzvedneme controller z kontejneru (už se všemi závislostmi)
        $controller = $this->diContainer->get($controllerClass);

        if (!method_exists($controller, $actionName)) {
            throw new Exception("Action '$actionName' not found in page '$controllerName'", 404);
        }

        $params = array_slice($segments, 2);
        call_user_func_array([$controller, $actionName], $params);
    }
}