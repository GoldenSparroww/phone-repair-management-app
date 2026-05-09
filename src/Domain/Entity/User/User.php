<?php

namespace App\Domain\Entity\User;

/**
 * Doménová entita reprezentující přihlášeného uživatele v systému.
 * Uchovává autentizační data a autorizační údaje nezbytné pro řízení přístupu.
 */
class User
{
    public function __construct(
        private int $id,
        private string $email,
        private UserRole $role,
        private string $hash
    ) {
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hash);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): UserRole {
        return $this->role;
    }
}