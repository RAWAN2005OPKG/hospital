<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Doctor = 'doctor';
    case Patient = 'patient';
}