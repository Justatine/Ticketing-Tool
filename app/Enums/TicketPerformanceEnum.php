<?php

namespace App\Enums;

enum RegionEnum: string
{
    case PASS = 'PASS';
    case FAIL = 'FAIL';
    case ONGOING = 'ONGOING';

    public function label(): string
    {
        return match($this) {
            self::PASS => 'Pass',
            self::FAIL => 'Fail',
            self::ONGOING => 'Ongoing',
        };
    }
}
