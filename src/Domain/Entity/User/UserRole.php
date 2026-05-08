<?php

namespace App\Domain\Entity\User;

enum UserRole: string
{
    case RECEPTIONIST = 'receptionist';
    case SERVICE_TECHNICIAN = 'service technician';
    case ADMIN = 'admin';
}