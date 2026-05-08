<?php
namespace App\Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Třída sloužící jako wrapper pro zobrazování twig šablon
 */
class ViewWrapper {
    private Environment $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../Templates');
        $this->twig = new Environment($loader, [
            'cache' => false, // nebo __DIR__ . '/../../cache'
            'debug' => true,
        ]);

        // Globální proměnné – dostupné ve všech šablonách
        // Pokud uživatel namá SESSION_COOKIE, tak vrátí prázné pole -> např. odhlášen
        $this->twig->addGlobal('session', Session::all());
    }

    /**
     * Má na starosti vypsání konrkténtí šablony
     * @param string $template Název Twig šablony (např. 'home.twig').
     * @param array $data Pole dat, která se předají šabloně pro renderování.
     * @return string Vygenerovaný HTML obsah.
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $template, array $data = []): string {
        if (Session::isLoggedIn() and Session::get("user") === 0){
            return $this->twig->render("UserBlocked.twig");
        }

        return $this->twig->render($template, $data);
    }
}
