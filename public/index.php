<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DIContainer;
use App\Core\Router;
use App\Core\ErrorHandler;
use App\Core\EnvHandler;
use App\Core\Session;
use App\Core\ViewWrapper;

$handler = new ErrorHandler();
$handler->register();
EnvHandler::load();
Session::start();

$container = new DIContainer();

// Ručně se musí registrovat jen věci, které vyžadují speciální nastavení
// Ruční registrace PDO instance do kontejneru
$container->set(PDO::class, function() {
    try {
        $db_type = \App\Core\EnvHandler::get('DB_TYPE');
        $db_charset = \App\Core\EnvHandler::get('DB_CHARSET');
        $db_host = \App\Core\EnvHandler::get('DB_HOST');
        $db_name = \App\Core\EnvHandler::get('DB_NAME');
        $db_user = \App\Core\EnvHandler::get('DB_USER');
        $db_pass = \App\Core\EnvHandler::get('DB_PASS');

        $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=$db_charset";

        return new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        throw new PDOException("Chyba při spojení s databází, zkuste to později. ".$e->getMessage());
    }
});

// Ruční registrace ViewWrapper do kontejneru
$container->set(ViewWrapper::class, function() {
    return new ViewWrapper();
});

// Všechno ostatní (Controller -> Service -> Repository -> DAO)
// se vyřeší samo při prvním zavolání v Routeru
$router = new Router($container);
$router->run();