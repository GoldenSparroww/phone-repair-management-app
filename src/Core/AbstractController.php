<?php

namespace App\Core;

abstract class AbstractController
{
    public function __construct(
        protected ViewWrapper $view
    ){}

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