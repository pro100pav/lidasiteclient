<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'social_group_id',
        'bot_message_id',
    ];

    public function message()
    {
        return $this->belongsTo(Bot\BotMessage::class);
    }

}
