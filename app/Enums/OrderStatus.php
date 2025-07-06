<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Pending = 0;
    case Confirmed = 1;
    case Preparing = 2;
    case ReadyForPickup = 3;
    case OutForDelivery = 4;
    case Completed = 5;
    case Cancelled = 6;
    case Refunded = 7;
}
