<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppActive extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'indefinitely',
        'active_at',
        'bot',
    ];
}
