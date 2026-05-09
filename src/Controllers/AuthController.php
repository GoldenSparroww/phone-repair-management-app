<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\AuthService;
use App\DTO\UserLoginDTO;
use App\Core\Session;

/**
 * Kontroler pro správu autentizace uživatelů.
 * Zpracovává HTTP požadavky pro přihlášení a odhlášení ze systému.
 */
final class AuthController extends AbstractController
{
    // Tento kontroler je veřejný, nevyžaduje přihlášení
    protected bool $requireAuth = false;

    public function __construct(
        private AuthService $authService,
        protected ViewWrapper $view,
    ) {
        parent::__construct($view);
    }

    public function login(): void
    {
        // Pokud už je uživatel přihlášený, nemá smysl mu ukazovat login page
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        $error = null;

        if ($this->isPost()) {
            $dto = new UserLoginDTO(
                $this->getPostParam('email'),
                $this->getPostParam('password')
            );

            if ($this->authService->login($dto)) {
                $this->redirect('/dashboard');
            }

            $error = 'Neplatné přihlašovací údaje';
        }

        echo $this->view->render('Auth.twig', ['error' => $error]);
    }

    public function logout(): void
    {
        $this->authService->logout();
        $this->redirect('/auth/login');
    }
}