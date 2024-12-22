<?php

namespace App\Models\Bot;

use App\Models\Bot\SocialGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialGroupUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'social_group_id',
        'id_telegram',
        'username',
        'name',
        'status',
    ];

    public function group()
    {
        return $this->belongsTo(SocialGroup::class,'social_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
