<?php

namespace App\DTO;

class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}