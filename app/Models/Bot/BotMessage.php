<?php

namespace App\Models\Bot;

use App\Models\Bot\BotTemplate;
use App\Models\Bot\SocialGroup;
use App\Models\Bot\BotItemMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_template_id',
        'name',
        'trigger',
        'id_message',
        'privat',
        'message',
    ];

    public function items()
    {
        return $this->hasMany(BotItemMessage::class);
    }
    public function template()
    {
        return $this->belongsTo(BotTemplate::class, 'bot_template_id');
    }
    public function groups()
    {
        return $this->belongsToMany(SocialGroup::class, 'group_messages');
    }

}
