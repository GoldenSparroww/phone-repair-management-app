<?php
namespace App\Domain\Entity\Employee;

use Exception;

/**
 * Doménová entita reprezentující zaměstnance.
 * Definuje pracovníky systému a jejich role (např. servisní technik, administrátor).
 */
class Employee
{
    private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private string $role;

    public function __construct(string $firstName, string $lastName, string $role)
    {
        $this->validateRole($role);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->validateRole($role);
        $this->role = $role;
    }

    private function validateRole(string $role): void
    {
        if ($role !== 'service technician') {
            throw new Exception("K opravě lze přiřadit pouze zaměstnance s rolí 'service technician'." . $role);
        }
    }
}