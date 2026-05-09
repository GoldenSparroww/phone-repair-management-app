<?php

namespace App\DTO;

/**
 * Datový přenosový objekt (DTO) pro přihlašovací údaje.
 * Zapouzdřuje data zadaná uživatelem při pokusu o přihlášení.
 */
class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}