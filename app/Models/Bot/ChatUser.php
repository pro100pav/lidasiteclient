<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\ChatUserMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_bot_id',
        'type',
        'close',
    ];


    public function botUs()
    {
      return $this->belongsTo(Bot::class, 'user_bot_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatUserMessage::class, 'chat_user_id');
    }
}
