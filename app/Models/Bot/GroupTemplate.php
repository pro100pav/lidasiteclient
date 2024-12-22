<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'social_group_id',
        'bot_template_id',
    ];

    public function template()
    {
        return $this->belongsTo(Bot\BotTemplate::class);
    }
}
