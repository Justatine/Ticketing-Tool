<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SA = 'SA';
    case USER = 'USER';

    public function label(): string
    {
        return match($this) {
            self::SA => 'Super Admin',
            self::USER => 'User',
        };
    }
}
