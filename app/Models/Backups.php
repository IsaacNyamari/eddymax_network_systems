<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backups extends Model
{
    protected $fillable = [
        'file',
        'path',
        'size',
        'note',
        'download_count',
        'last_downloaded_at'
    ];
}
