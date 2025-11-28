<?php

namespace App\Enums;

enum RegionEnum: string
{
    case PASS = 'PASS';
    case FAIL = 'FAIL';

    public function label(): string
    {
        return match($this) {
            self::PASS => 'Pass',
            self::FAIL => 'Fail',
        };
    }
}
