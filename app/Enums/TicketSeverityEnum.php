<?php

namespace App\Enums;

enum TicketSeverityEnum: string
{
    case LOW = 'LOW';
    case NORMAL = 'NORMAL';
    case HIGH = 'HIGH';
    case CRITICAL = 'CRITICAL';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::NORMAL => 'Normal',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }
}
