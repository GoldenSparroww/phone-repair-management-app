<?php

namespace App\Core;

use Throwable;
use ErrorException;

/**
 * Třída zajišťující správné uchopení a zpracování všech chyb aplikace
 */
class ErrorHandler
{
    /**
     * Nastaví ErrorHandler jako třídu pro zachytávání errorů napříč celou aplikací.
     * @return void
     */
    public function register(): void
    {
        // OD VERZE PHP 8 SE DÍKY THROWABLE HODNĚ VĚCÍ ZJEDNODUŠILO
        // (např. register_shutdown_function([$this, 'handleShutdown']) už není třeba)

        // Zpracování běžných PHP chyb
        set_error_handler([$this, 'handleError']);
        // Zpracování výjimek (throwables)
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * Tato metoda má za úkol převést běžné jednodušší chyby na širší typ chyby, čímž mohu poté zachytávání centralizovat jedním způsobem.
     * @param int $errno úroveň chyby (dodáno automaticky, pokud vůbec)
     * @param string $errstr chybová zpráva, popis
     * @param string $errfile soubor chyby, název a cesta
     * @param int $errline (řádek chyby)
     * @return void
     * @throws ErrorException vyhodí vždy, transformaci zachycené výjimky
     */
    //Převod běžných chyb a varování na výjimky (např. Undefined variable $as)
    public function handleError(int $errno, string $errstr, string $errfile, int $errline): void
    {
        throw new ErrorException($errstr, 500, $errno, $errfile, $errline);
    }

    /**
     * Sem cílí každá chyba aplikace, je náležitě zpracována a stav je vypsán pomocí error stránky
     * @param Throwable $exception zachycená výjimka
     * @return void
     */
    public function handleException(Throwable $exception): void
    {
        $code = $exception->getCode();
        // Pojistka, kdyby přišel nevalidní kód (žádný/0, 999, -1 atd.)
        // HTTP status kódy v rozsahu 400–599 jsou vyhrazeny pro chyby
        $status = ($code >= 400 && $code < 600) ? $code : 500;
        http_response_code($status);

        $view = new ViewWrapper();
        echo $view->render('Error.twig', [
            'error_code' => $status,
            'error_message' => $this->getErrorMessage($exception),
            //'error_file' => $exception->getFile(),
            //'error_line' => $exception->getLine(),
        ]);
    }

    /**
     * Metoda pro zpracování chybových zpráv, hlavně pro zakrytí reálných problému uživateli
     * @param Throwable $exception
     * @return string
     */
    public function getErrorMessage(Throwable $exception): string
    {
        return $exception->getMessage();

        if ($exception->getCode() === 500) {
            return "Interní chyba serveru.";
        } elseif ($exception->getCode() === 404) {
            return "Stránka nenalezena.";
        } else {
            return "Nastala neočekávaná chyba při zpracování.";
        }
    }
}
