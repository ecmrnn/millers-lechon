<?php

namespace App\Enums;

enum OrderStatus: int
{
    case ORDERED = 0;
    case CONFIRMED = 1;
    case PREPARING = 2;
    case PREPARED = 3;
    case PICKED_UP = 4;
    case DELIVERING = 5;
    case DELIVERED = 6;
    case CANCELED = 7;

    public function label() {
        return match ($this) {
            self::ORDERED => 'Ordered',
            self::CONFIRMED => 'Confirmed',
            self::PREPARING => 'Preparing',
            self::PREPARED => 'Ready for Pick Up',
            self::PICKED_UP => 'Picked Up',
            self::DELIVERING => 'On the Road',
            self::DELIVERED => 'Delivered',
        };
    }

    public function summary(): string
    {
        return match ($this) {
            self::ORDERED => 'Your order was placed.',
            self::CONFIRMED => 'Your payment was confirmed.',
            self::PREPARING => 'Your order was prepared.',
            self::PREPARED => 'Your order was ready for shipping.',
            self::PICKED_UP => 'Your order was picked up by the courier.',
            self::DELIVERING => 'Courier picked up your order.',
            self::DELIVERED => 'Your order was delivered.',
        };
    }

    public static function default() {
        return [
            self::ORDERED,
            self::CONFIRMED,
            self::PREPARING,
            self::PREPARED,
        ];
    }

    public static function forPickUp() {
        return [
            ...self::default(),
            self::PICKED_UP
        ];
    }

    public static function forDelivery() {
        return [
            ...self::default(),
            self::DELIVERING,
            self::DELIVERED,
        ];
    }
}
