<?php

namespace App\Models\Bot;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_id',
        'user_id',
        'text',
        'send',
        'images',
        'video',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
