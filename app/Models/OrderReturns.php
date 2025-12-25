<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReturns extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel naming convention)
    protected $table = 'order_returns';

    // Mass assignable fields
    protected $fillable = [
        'order_id',
        'type',      // 'cancel' or 'return'
        'status',    // 'pending', 'approved', 'rejected'
        'reason',
    ];

    // Casts (optional, keeps enums as strings)
    protected $casts = [
        'type' => 'string',
        'status' => 'string',
    ];

    /**
     * Relationship to the Order model
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
