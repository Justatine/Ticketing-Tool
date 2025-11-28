<?php

namespace App\Enums;

enum TeamEnum: string
{
    case ITPM1 = 'ITPM1';
    case ITPM2 = 'ITPM2';
    case SD = 'SD';
    case INFRA = 'INFRA';

    public function label(): string
    {
        return match($this) {
            self::ITPM1 => 'IT PM Riggs',
            self::ITPM2 => 'IT PM Genes',
            self::SD => 'Service Delivery Team',
            self::INFRA => 'Infra Team',
        };
    }
}
