<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationsFactory> */
    use HasFactory, SoftDeletes;
    public $fillable = [
        'notifiable_id',
        'notifiable_type',
        'message',
        'type'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
