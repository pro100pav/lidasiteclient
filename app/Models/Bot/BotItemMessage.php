<?php

namespace App\Models\Bot;

use App\Models\Bot\BotButton;
use App\Models\Bot\BotMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotItemMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_message_id',
        'message',
        'images',
        'video',
        'type_button',
        'function',
        'fixed',
        'video_notice',
        'privat',
    ];
    public function buttons()
    {
        return $this->hasMany(BotButton::class);
    }
    public function messageParent()
    {
        return $this->belongsTo(BotMessage::class,'bot_message_id');
    }
}
