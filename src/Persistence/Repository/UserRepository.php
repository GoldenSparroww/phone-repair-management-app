<?php

namespace App\Persistence\Repository;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRole;
use App\Persistence\DAO\UserDAO;

/**
 * Repozitář pro entity User.
 * Zajišťuje načítání a instancování objektů uživatelů pro potřeby ověření přístupu.
 */
class UserRepository
{
    public function __construct(
        private UserDAO $userDAO
    ) {}

    public function getByEmail(string $email): ?User
    {
        $data = $this->userDAO->findByEmail($email);

        if ($data === null) {
            return null;
        }

        return new User(
            $data['id'],
            $data['email'],
            UserRole::from($data['role']),
            $data['hash'],
        );
    }
}