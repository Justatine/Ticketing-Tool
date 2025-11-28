<?php

namespace App\Enums;

enum TicketCategoryEnum: string
{
    case RENEWAL = 'RENEWAL';
    case ACCREGISTRATION = 'ACCREGISTRATION';
    case CCTV = 'CCTV';
    case JBMIS = 'JBMIS';
    case NETWORK = 'NETWORK';
    case SERVER = 'SERVER';
    case POS = 'POS';
    case TOT = 'TOT';
    case MAINTENANCE = 'MAINTENANCE';
    case SAP = 'SAP';
    case PORTAL = 'PORTAL';

    public function label(): string
    {
        return match($this) {
            self::RENEWAL => 'Renewal',
            self::ACCREGISTRATION => 'Account Registration',
            self::CCTV => 'CCTV Support',
            self::JBMIS => 'JBMIS',
            self::NETWORK => 'Network',
            self::SERVER => 'Server',
            self::POS => 'POS Support',
            self::TOT => 'TOT',
            self::MAINTENANCE => 'Maintenance',
            self::SAP => 'SAP',
            self::PORTAL => 'Portal',
        };
    }
}
