<?php

namespace App\Models\Bot;

use App\Models\Bot\BotItemMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotButton extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_item_message_id',
        'text',
        'type_button',
        'callback_button',
    ];

    public function mesItem()
    {
        return $this->belongsTo(BotItemMessages::class);
    }
}
