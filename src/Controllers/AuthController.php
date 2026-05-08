<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ViewWrapper;
use App\Services\AuthService;
use App\DTO\UserLoginDTO;

final class AuthController extends AbstractController
{
    public function __construct(
        private AuthService $authService,
        protected ViewWrapper $view,
    ) {
        parent::__construct($view);
    }

    public function login(): void
    {
        $error = null;

        if ($this->isPost()) {
            $dto = new UserLoginDTO(
                $this->getPostParam('email'),
                $this->getPostParam('password')
            );

            if ($this->authService->login($dto)) {
                $this->redirect('/home/index');
            }

            $error = 'Neplatné přihlašovací údaje';
        }

        echo $this->view->render('Auth.twig', ['error' => $error]);
    }

    public function logout(): void
    {
        $this->authService->logout();
        $this->redirect('/home/index');
    }
}