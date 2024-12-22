<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\ChatUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBot extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bot_id',
        'sending',
        'status',
        'last_message_id',
        'last_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
    public function chat()
    {
        return $this->hasOne(ChatUser::class);
    }
}
