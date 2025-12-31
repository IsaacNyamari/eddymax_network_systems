<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_number',
        'products',
        'status',
        'total_amount',
        'shipping_address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments()
    {
        return $this->hasOne(Payment::class);
    }
    public function orderItems()
    {
       return $this->hasMany(OrderItem::class);
    }
    public function product()
    {
       return $this->belongsTo(Product::class, "product_id");
    }
    public function orderReturns(): HasOne
    {
        return $this->hasOne(OrderReturns::class, 'order_id');
    }
}
