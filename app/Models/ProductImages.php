<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImagesFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type'
    ];

    // Polymorphic relationship
    public function imageable()
    {
        return $this->morphTo();
    }

    // If you want a direct relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'imageable_id')
            ->where('imageable_type', Product::class);
    }
}
