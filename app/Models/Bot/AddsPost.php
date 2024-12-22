<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\BotUser;
use App\Models\Bot\SendMessagePost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddsPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bot_id',
        'content',
        'attachment',
        'bot',
        'button',
        'status',
        'message_ids',
        'sendstart_at',
    ];
    /*
        статусы:
        1 - создается
        2 - В очереди на рассылку
        3 - Рассылается
        4 - Разослался
    */
    public function boting()
    {
      return $this->belongsTo(Bot::class, 'bot_id');
    }
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
    public function messageSend()
    {
      return $this->hasMany(SendMessagePost::class);
    }
}
