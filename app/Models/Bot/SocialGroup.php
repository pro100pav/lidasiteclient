<?php

namespace App\Models\Bot;

use App\Models\Bot\Bot;
use App\Models\Bot\SocialGroupUser;
use App\Models\Bot\GroupMessage;
use App\Models\Bot\GroupTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_id',
        'id_group',
        'group_name',
        'username',
        'type',
        'role',
        'status',
        'link',
        'podpiska',
    ];

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
    public function groupUser()
    {
        return $this->hasMany(SocialGroupUser::class);
    }

    public function groupTemplate()
    {
        return $this->belongsToMany(BotTemplate::class, 'group_templates');
    }
    public function groupMessage()
    {
        return $this->belongsToMany(BotMessage::class, 'group_messages');
    }
}
