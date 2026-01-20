<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'amount',
        'reference',
        'transaction_code',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
