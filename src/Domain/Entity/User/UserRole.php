<?php

namespace App\Domain\Entity\User;

/**
 * Reprezentace uživatelských rolí v systému pro potřeby autorizace.
 */
enum UserRole: string
{
    case RECEPTIONIST = 'receptionist';
    case SERVICE_TECHNICIAN = 'service technician';
    case ADMIN = 'admin';
}