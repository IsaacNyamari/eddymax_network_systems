<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRating extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id',
        'rate_count',
        'comment'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}