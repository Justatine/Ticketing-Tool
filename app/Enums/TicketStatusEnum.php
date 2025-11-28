<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    case OPEN = 'OPEN';
    case NEW = 'NEW';
    case INPROG = 'INPROG';
    case PENDING = 'PENDING';
    case VOID = 'VOID';
    case CLOSED = 'CLOSED';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Open',
            self::NEW => 'New',
            self::INPROG => 'In Progress',
            self::PENDING => 'Pending',
            self::CLOSED => 'Closed',
            self::VOID => 'Void',
        };
    }
}
