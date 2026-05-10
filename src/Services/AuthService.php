<?php

namespace App\Services;

use App\Core\Session;
use App\DTO\UserLoginDTO;
use App\Persistence\Repository\UserRepository;

/**
 * Služba zapouzdřující logiku autentizace.
 * Ověřuje přihlašovací údaje a inicializuje uživatelskou relaci.
 */
class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function login(UserLoginDTO $dto): bool
    {
        $user = $this->userRepository->getByEmail($dto->email);

        if ($user !== null && $user->verifyPassword($dto->password)) {
            // Ukládáme jen to důležité
            Session::set('user', [
                'id'    => $user->getId(),
                'email' => $user->getEmail(),
                'role'  => $user->getRole()->value,
            ]);
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        Session::destroy();
    }
}