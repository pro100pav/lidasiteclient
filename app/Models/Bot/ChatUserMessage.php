<?php

namespace App\Models\Bot;

use App\Models\ChatUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUserMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_user_id',
        'message_user',
        'message_bot',
        'attachment',
        'type_attach',
    ];

    public function chat()
    {
        return $this->belongsTo(Bot\ChatUser::class);
    }
}
