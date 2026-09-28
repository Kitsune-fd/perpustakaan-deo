<?php

namespace App\Enums;

enum Status: string
{
    case RESERVED = 'reserved';
    case LOANED = 'loaned';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::LOANED => 'Dipinjam',
            self::RESERVED => 'Dipesan',
            self::RETURNED => 'Dikembalikan',
            self::CANCELED => 'Dibatalkan',
            self::OVERDUE => 'Terlambat',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LOANED => 'bg-warning',
            self::RESERVED => 'bg-primary',
            self::RETURNED => 'bg-success',
            self::CANCELED => 'bg-secondary',
            self::OVERDUE => 'bg-danger',
        };
    }
}