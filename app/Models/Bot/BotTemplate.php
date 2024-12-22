<?php

namespace App\Models\Bot;

use App\Models\Bot\Bot;
use App\Models\Bot\BotMessage;
use App\Models\Bot\SocialGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_id',
        'name',
        'description',
        'active',
        'privat',
        'message',
    ];

    public function messages()
    {
        return $this->hasMany(BotMessage::class);
    }
    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
    public function groups()
    {
        return $this->belongsToMany(SocialGroup::class, 'group_templates');
    }
}
