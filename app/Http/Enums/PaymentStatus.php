<?php

namespace App\Http\Enums;

enum RoomStatus :string
{
    case FREE = 'free';
    case BUSY = 'busy';

    public static function values() {
        return array_column(self::cases(), 'value');
    }

    public static function isValid($value)
    {
        return in_array($value, self::values());
    }
}
