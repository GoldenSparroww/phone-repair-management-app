<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DIContainer;
use App\Core\Router;
use App\Core\ErrorHandler;
use App\Core\EnvHandler;
use App\Core\Session;

$handler = new ErrorHandler();
$handler->register();
EnvHandler::load();
Session::start();

$container = new DIContainer();

// Ručně musíme registrovat jen věci, které vyžadují speciální nastavení
// nebo rozhraní, u kterých chceme říct, která konkrétní třída je implementuje.
$container->set(\App\Core\ViewWrapper::class, function() {
    return new \App\Core\ViewWrapper();
});

// Všechno ostatní (Controller -> Service -> Repository -> DAO)
// se vyřeší samo při prvním zavolání v Routeru!

$router = new Router($container);
$router->run();