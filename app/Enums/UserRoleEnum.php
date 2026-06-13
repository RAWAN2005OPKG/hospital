<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Receptionist = 'receptionist';
    case Doctor = 'doctor';
    case Patient = 'patient';

    public function isStaff(): bool
    {
        return $this === self::Admin || $this === self::Receptionist;
    }
}