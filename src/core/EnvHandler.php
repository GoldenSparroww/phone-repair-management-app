<?php
namespace App\Core;

use App\Core\Helpers;
use Dotenv\Dotenv;

/**
 * Třída zajišťující a obalující práci se soubory .env
 */
class EnvHandler {
    /**
     * Načte .env soubor do aplikace
     * @return void
     */
    public static function load(): void {
        $path = Helpers::path_join(__DIR__, '../..');
        $dotenv = Dotenv::createImmutable($path);
        $dotenv->load();
    }

    /**
     * @param string $key Klíč do .env souboru
     * @return string Hodnota pod klíčem
     */
    public static function get(string $key): string {
        return $_ENV[$key];
    }
}