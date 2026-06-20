<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Receptionist = 'receptionist';
    case Doctor = 'doctor';
    case Patient = 'patient';
    case Pharmacist = 'pharmacist';

    public function isStaff(): bool
    {
        return $this === self::Admin || $this === self::Receptionist || $this === self::Pharmacist;
    }
}