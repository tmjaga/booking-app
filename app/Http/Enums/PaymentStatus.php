<?php

namespace App\Http\Enums;

enum PaymentStatus :string
{
    case PENDING = 'pending';
    case FAILED = 'failed';
    case PROCESSED = 'processed';

    public static function values() {
        return array_column(self::cases(), 'value');
    }

    public static function isValid($value)
    {
        return in_array($value, self::values());
    }
}
