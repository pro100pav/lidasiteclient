<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Bot\Bot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotStep extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bot_id',
        'step',
    ];

    public function boting()
    {
      return $this->belongsTo(Bot::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
