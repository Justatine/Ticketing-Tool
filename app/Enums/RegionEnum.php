<?php

namespace App\Enums;

enum RegionEnum: string
{
    case MIN = 'MIN';
    case VIS = 'VIS';
    case LUZ = 'LUZ';

    public function label(): string
    {
        return match($this) {
            self::MIN => 'Mindanao',
            self::VIS => 'Visayas',
            self::LUZ => 'Luzon',
        };
    }
}
