<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Payment;
use App\Models\Bot\UserBot;
use App\Models\Bot\BotStep;
use App\Models\Bot\BotTemplate;
use App\Models\Bot\SocialGroup;
use App\Models\Bot\ChatUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'token',
        'name',
        'link',
        'webhook',
        'price_ads',
        'price_visitka',
        'price_cepochka',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userBot()
    {
        return $this->hasMany(UserBot::class);
    }

    public function botStep()
    {
        return $this->hasMany(BotStep::class);
    }

    public function template()
    {
        return $this->hasMany(BotTemplate::class);
    }
    public function chat()
    {
        return $this->hasMany(ChatUser::class);
    }
    public function posts()
    {
      return $this->hasMany(AddsPost::class, 'bot_id');
    }
}
