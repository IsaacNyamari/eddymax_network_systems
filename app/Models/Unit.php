<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'unitable_id',
        'unitable_type',
    ];

    public function unitable()
    {
        return $this->morphTo();
    }
}
