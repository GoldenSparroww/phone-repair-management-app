<?php
namespace App\Core;

/**
 * Třídá jako wrapper pro práci se session
 */
class Session
{
    /**
     * Spustí session pokud ještě není
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Nastaví do session danou hodnotu pod daným klíčem
     * @param string $key Klíč
     * @param mixed $value Hodnota
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Získá hodnotu ze session
     * @param string $key Klíč, pod kterým je hodnota uložena.
     * @param mixed|null $default Hodnota, která se má vrátit, pokud klíč v session neexistuje.
     * @return mixed Načtená hodnota nebo výchozí hodnota.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Odebere hodnotu ze session
     * @param string $key Klíč
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Zničí session
     * @return void
     */
    public static function destroy(): void
    {
        // vymaže paměť, pole $_SESSION by bylo jinak stále k dispozici po zbytek aktuálního skriptu
        $_SESSION = [];
        // zničí session na server
        session_destroy();
        // nechá vypršet platnost session cookie u uživatele
        setcookie(session_name(), '', time() - 3600, '/');
    }

    /**
     * @return array všechen obsah session
     */
    public static function all(): array
    {
        return $_SESSION ?? [];
    }

    /**
     * @return bool true pokud je uživatel přihlášen, jinak false
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Vrátí uživatele pokud existuje
     * @return array|null
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}
