<?php

namespace App\Core;

abstract class AbstractController
{
    // Ve výchozím stavu všechny kontrolery vyžadují přihlášení
    protected bool $requireAuth = true;

    public function __construct(
        protected ViewWrapper $view
    ) {
        if ($this->requireAuth && !Session::isLoggedIn()) {
            $this->redirect('/auth/login');
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getPostParam(string $key, $default = ''): string
    {
        return htmlspecialchars(trim($_POST[$key] ?? $default));
    }
}