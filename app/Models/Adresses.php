<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresses extends Model
{
    /** @use HasFactory<\Database\Factories\AdressesFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'county_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function county()
    {
        return $this->belongsTo(Counties::class, 'county_id');
    }
}
