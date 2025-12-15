<?php

namespace App;

enum PaymentStatus: string
{
    case PAID =  'paid';
    case NOTPAID =  'not_paid';
}
