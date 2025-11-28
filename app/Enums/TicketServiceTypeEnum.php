<?php

namespace App\Enums;

enum RegionEnum: string
{
    case SERVICE = 'SERVICE';
    case INCIDENT = 'INCIDENT';

    public function label(): string
    {
        return match($this) {
            self::SERVICE => 'Service',
            self::INCIDENT => 'Incident',
        };
    }
}
