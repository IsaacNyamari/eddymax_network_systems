<?php

namespace App;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';
    case SHIPPED = 'shipped';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
}
